<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\PaymentMail;
use App\Mail\ReceiptMail;
use App\Models\Country;
use App\Models\Product;
use App\Models\Payment;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use App\Models\Address; // Import the Address model
use App\Models\FreeDeliverySetting;
use App\Models\Order;   // Import the Order model (for future use, if not already used)
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Get the maximum allowed weight for a shipping zone.
     * 
     * @param int $zone_id
     * @return float|null Maximum weight in grams, or null if no rates found
     */
    private function getMaxWeightForZone($zone_id)
    {
        $maxRate = ShippingRate::where('shipping_zone_id', $zone_id)
            ->orderBy('weight_to', 'desc')
            ->first();

        return $maxRate ? $maxRate->weight_to : null;
    }

    /**
     * Check if customer is making their first order (by email)
     * 
     * @param string $email
     * @return bool
     */
    private function isFirstTimeCustomer(?string $email): bool
    {
        if (empty($email)) {
            return false;
        }
    
        $email = strtolower(trim($email));
    
        $hasPaidOrder = Order::whereHas('billingAddress', function ($query) use ($email) {
                $query->whereRaw('LOWER(email) = ?', [$email]);
            })
            ->where('payment_status', 'paid')
            ->exists();
    
        Log::info('First order check', [
            'email' => $email,
            'has_paid_order' => $hasPaidOrder,
        ]);
    
        return !$hasPaidOrder;
    }
    

    /**
     * Calculate first order discount (10%)
     * 
     * @param float $subtotal
     * @return array ['discount_amount' => float, 'discounted_subtotal' => float]
     */
    private function calculateFirstOrderDiscount($subtotal)
    {
        $discountPercentage = 10; // 10% discount
        $discountAmount = ($subtotal * $discountPercentage) / 100;
        $discountedSubtotal = $subtotal - $discountAmount;

        return [
            'discount_amount' => round($discountAmount, 2),
            'discounted_subtotal' => round($discountedSubtotal, 2)
        ];
    }

    /**
     * Check if order qualifies for free shipping (uses admin-configured rules).
     *
     * @param Address|null $address
     * @param float $discountedSubtotal
     * @return bool
     */
    private function qualifiesForFreeShipping($address, $discountedSubtotal)
    {
        $countryId = $address && $address->country ? $address->country_id : null;
        return FreeDeliverySetting::orderQualifies($countryId, (float) $discountedSubtotal);
    }

    /**
     * Calculate shipping cost using tiered pricing model.
     * Sums up costs for each weight tier the order spans across.
     * 
     * @param int $zone_id
     * @param float $weight
     * @return array|null ['rate' => float, 'breakdown' => array] or null if invalid
     */
    private function calculateTieredShipping($zone_id, $weight)
    {
        // Validate weight
        if ($weight <= 0 || !is_numeric($weight)) {
            return null;
        }

        // Get all rates for this zone, ordered by weight_from
        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->orderBy('weight_from', 'asc')
            ->get();

        if ($rates->isEmpty()) {
            return null;
        }

        // Get the shipping zone to identify the carrier
        $zone = ShippingZone::find($zone_id);
        $isTipsa = $zone && (stripos($zone->zone_name, 'Tipsa') !== false);
        $isCorreos = $zone && (stripos($zone->zone_name, 'Correos') !== false);

        // Find the appropriate tier for the weight (flat rate per tier)
        foreach ($rates as $rate) {
            // Check if weight falls within this tier's range
            if ($weight >= $rate->weight_from && $weight <= $rate->weight_to) {
                return [
                    'rate' => $rate->rate,
                    'breakdown' => [
                        [
                            'tier' => "{$rate->weight_from}-{$rate->weight_to}g",
                            'weight' => $weight,
                            'cost' => $rate->rate
                        ]
                    ]
                ];
            }
        }

        // If weight is below the minimum tier, use the lowest tier rate
        $minRate = $rates->first();
        if ($weight < $minRate->weight_from) {
            return [
                'rate' => $minRate->rate,
                'breakdown' => [
                    [
                        'tier' => "{$minRate->weight_from}-{$minRate->weight_to}g (minimum)",
                        'weight' => $weight,
                        'cost' => $minRate->rate
                    ]
                ]
            ];
        }

        // If weight exceeds all tiers, calculate excess cost based on carrier type
        $maxRate = $rates->last();
        $remainingWeight = $weight;
        $totalCost = 0;
        $breakdown = [];

        if ($isTipsa) {
            // Tipsa: Fixed 0.60 EUR per 100g increment above maximum
            $breakdown[] = [
                'tier' => "{$maxRate->weight_from}-{$maxRate->weight_to}g (base)",
                'weight' => $maxRate->weight_to,
                'cost' => $maxRate->rate
            ];
            $totalCost += $maxRate->rate;

            $excessWeight = $weight - $maxRate->weight_to;
            $incrementUnit = 100; // 100g increments
            $incrementCost = 0.60; // EUR per increment
            $numberOfIncrements = ceil($excessWeight / $incrementUnit);
            $excessCost = $numberOfIncrements * $incrementCost;

            $breakdown[] = [
                'tier' => "Above {$maxRate->weight_to}g (excess: {$excessWeight}g, {$numberOfIncrements} × {$incrementUnit}g @ {$incrementCost} EUR)",
                'weight' => $excessWeight,
                'cost' => round($excessCost, 2)
            ];

            $totalCost += $excessCost;

        } elseif ($isCorreos) {
            // Correos: Iteratively subtract highest tier range and charge full tier rate each time
            $maxTierRange = $maxRate->weight_to - $maxRate->weight_from;
            $chargeCount = 0;

            // Keep subtracting the highest tier's weight_to until we can't anymore
            while ($remainingWeight > $maxRate->weight_to) {
                $chargeCount++;
                $breakdown[] = [
                    'tier' => "{$maxRate->weight_from}-{$maxRate->weight_to}g (cycle {$chargeCount})",
                    'weight' => $maxRate->weight_to,
                    'cost' => $maxRate->rate
                ];
                $totalCost += $maxRate->rate;
                $remainingWeight -= $maxRate->weight_to;
            }

            // Handle remaining weight: find which tier it falls into
            if ($remainingWeight > 0) {
                $tierFound = false;

                // Check each tier from highest to lowest to find where remainder fits
                foreach ($rates->reverse() as $rate) {
                    if ($remainingWeight >= $rate->weight_from && $remainingWeight <= $rate->weight_to) {
                        $breakdown[] = [
                            'tier' => "{$rate->weight_from}-{$rate->weight_to}g (remainder: {$remainingWeight}g)",
                            'weight' => $remainingWeight,
                            'cost' => $rate->rate
                        ];
                        $totalCost += $rate->rate;
                        $tierFound = true;
                        break;
                    }
                }

                // If remainder is below minimum tier, use the lowest tier rate
                if (!$tierFound) {
                    $minRate = $rates->first();
                    $breakdown[] = [
                        'tier' => "{$minRate->weight_from}-{$minRate->weight_to}g (remainder: {$remainingWeight}g, minimum)",
                        'weight' => $remainingWeight,
                        'cost' => $minRate->rate
                    ];
                    $totalCost += $minRate->rate;
                }
            }

        } else {
            // Unknown carrier: use default calculation (highest tier's cost per gram)
            $breakdown[] = [
                'tier' => "{$maxRate->weight_from}-{$maxRate->weight_to}g (base)",
                'weight' => $maxRate->weight_to,
                'cost' => $maxRate->rate
            ];
            $totalCost += $maxRate->rate;

            $excessWeight = $weight - $maxRate->weight_to;
            $tierWeightRange = $maxRate->weight_to - $maxRate->weight_from;

            if ($tierWeightRange > 0) {
                $costPerGram = $maxRate->rate / $tierWeightRange;
                $excessCost = $excessWeight * $costPerGram;
            } else {
                $excessCost = 0;
            }

            $breakdown[] = [
                'tier' => "Above {$maxRate->weight_to}g (excess: {$excessWeight}g)",
                'weight' => $excessWeight,
                'cost' => round($excessCost, 2)
            ];

            $totalCost += $excessCost;
        }

        return [
            'rate' => round($totalCost, 2),
            'breakdown' => $breakdown
        ];
    }

    /**
     * Get shipping rate for a given zone and weight (legacy method - now uses tiered pricing).
     * 
     * @param int $zone_id
     * @param float $weight
     * @return object|null ShippingRate-like object with rate property
     */
    private function getShippingRate($zone_id, $weight)
    {
        $result = $this->calculateTieredShipping($zone_id, $weight);

        if (!$result) {
            return null;
        }

        // Return an object with rate property for backward compatibility
        return (object) ['rate' => $result['rate']];
    }

    /**
     * Display the checkout page with guest's address and cart details.
     */
    public function index(Request $request)
    {
        $userAddress = null;

        // Try to get cart from request, otherwise use empty array
        // Cart is typically loaded from localStorage on the client side
        $cartItems = [];
        if ($request->has('cart') && !empty($request->cart)) {
            $cartItems = json_decode($request->cart, true) ?? [];
        }

        $scountries = Country::where('status', '=', 1)->get();

        // Try to retrieve the address ID from the session for guests
        $guestAddressId = Session::get('guest_billing_address_id');

        if ($guestAddressId) {
            $userAddress = Address::with(['zone', 'country'])->find($guestAddressId);
        }

        return view('frontend.partials.checkoutDetails', [
            'editingAddress' => $request->has('edit_address'),
            'userAddress' => $userAddress, // This will be an Address model instance or null
            'cartItems' => $cartItems,
            'countries' => $scountries,
        ]);
    }

    public function single(Request $request)
    {
        if (!$request->product_id) {
            abort(404);
        }

        $scountries = Country::where('status', '=', 1)->get();
        $product = Product::with('sizes')->find($request->product_id);  // Updated: Load sizes

        $size_id = $request->size_id ?? null;  // NEW: Get size_id from URL

        $selectedSize = null;
        if ($size_id) {
            $selectedSize = $product->sizes->firstWhere('id', $size_id);  // NEW: Find selected size
            if (!$selectedSize) {
                abort(404); // Invalid size_id
            }
        }

        $userAddress = null;

        // Try to retrieve the address ID from the session for guests
        $guestAddressId = Session::get('guest_billing_address_id');

        if ($guestAddressId) {
            $userAddress = Address::with(['zone', 'country'])->find($guestAddressId);
        }

        // Get cart items from the session (as implemented previously)
        $cartItems = Session::get('current_cart_for_checkout', []);

        return view('frontend.partials.checkoutDetailsSingle', [
            'editingAddress' => $request->has('edit_address'),
            'userAddress' => $userAddress, // This will be an Address model instance or null
            'cartItems' => $cartItems,
            'countries' => $scountries,
            'product' => $product,
            'quantity' => $request->quantity,
            'size_id' => $size_id,  // NEW: Pass size_id to view
            'selectedSize' => $selectedSize  // NEW: Pass selected size to view
        ]);
    }

    public function getRegionByCountry(Request $request)
    {
        $zones = ShippingZone::where('country_id', $request->country_id)->get();

        return view('frontend.partials.zone-option', compact('zones'));
    }

    /**
     * Get available shipping methods (carriers) for a region/zone
     * Returns zones grouped by carrier name
     */
    public function getShippingMethods(Request $request)
    {
        $zone_id = $request->zone_id;

        if (!$zone_id) {
            return response()->json(['methods' => []]);
        }

        // Get the zone to find its country and region
        $selectedZone = ShippingZone::with('country')->find($zone_id);

        if (!$selectedZone) {
            return response()->json(['methods' => []]);
        }

        // Get all zones for this country that match the region
        // Region matching: could be exact match or if region dropdown uses zone_id, use that zone's region
        $allZones = ShippingZone::where('country_id', $selectedZone->country_id)
            ->where('region', $selectedZone->region)
            ->get();

        // If no zones found with exact region match, try to find zones by country only
        if ($allZones->isEmpty()) {
            $allZones = ShippingZone::where('country_id', $selectedZone->country_id)->get();
        }

        // Group by carrier name and create methods array
        $methods = [];
        $seen = [];

        foreach ($allZones as $shippingZone) {
            // Create unique key to avoid duplicates
            $key = $shippingZone->zone_name . '_' . $shippingZone->region;

            if (!in_array($key, $seen)) {
                $seen[] = $key;
                $methods[] = [
                    'id' => $shippingZone->id,
                    'carrier' => $shippingZone->zone_name,
                    'region' => $shippingZone->region,
                    'zone_id' => $shippingZone->id
                ];
            }
        }

        return response()->json(['methods' => $methods]);
    }

    public function calculatePrice(Request $request)
    {
        $quantity = $request->qty;
        $product_id = $request->id;
        $zone_id = $request->zone_id;
        $size_id = $request->size_id ?? null;  // NEW: Optional size_id param

        // get product details
        $product = Product::with('sizes')->findOrFail($product_id);  // Updated: Load sizes

        $price = $product->getPrice();  // Default price

        if ($size_id) {
            $size = $product->sizes->firstWhere('id', $size_id);
            if ($size) {
                $price = $size->price;  // Use size price if available
                // Weight remains product-level (add size->weight if added to model)
            }
        }

        // Safely handle null/zero weights
        $productWeight = ($product->weight && $product->weight > 0) ? $product->weight : 0;
        $weight = $productWeight * $quantity;

        $rates = $this->getShippingRate($zone_id, $weight);

        $total_price = $price * $quantity;
        // Use highest rate if weight exceeds max, or 0 if no rate found
        $total_shipping = $rates ? $rates->rate : 0;

        // Check if customer is first-time (need email from request)
        $customerEmail = $request->input('email');
        $address = null;
        if (!$customerEmail) {
            // Try to get from session address
            $guestAddressId = Session::get('guest_billing_address_id');
            if ($guestAddressId) {
                $address = Address::with('country')->find($guestAddressId);
                $customerEmail = $address ? $address->email : null;
            }
        } else {
            // If email provided, try to get address from session
            $guestAddressId = Session::get('guest_billing_address_id');
            if ($guestAddressId) {
                $address = Address::with('country')->find($guestAddressId);
            }
        }

        // Calculate discount if first-time customer
        $isFirstOrder = $this->isFirstTimeCustomer($customerEmail);
        $discountAmount = 0;
        $discountedSubtotal = $total_price;
        if ($isFirstOrder) {
            $discountData = $this->calculateFirstOrderDiscount($total_price);
            $discountAmount = $discountData['discount_amount'];
            $discountedSubtotal = $discountData['discounted_subtotal'];
        }

        // Check for free shipping (Spain orders over €70)
        if ($this->qualifiesForFreeShipping($address, $discountedSubtotal)) {
            $total_shipping = 0;
        }

        // Calculate grand total with discount
        $grand_total = $total_shipping + $discountedSubtotal;

        // Get the shipping zone to get carrier name
        $zone = ShippingZone::find($zone_id);
        $carrier_name = $zone ? $zone->zone_name : '';

        return view('frontend.partials.checkoutSummary', compact('total_price', 'discountAmount', 'isFirstOrder', 'discountedSubtotal', 'total_shipping', 'grand_total', 'carrier_name', 'customerEmail'));
    }

    public function getPrice(Request $request)
    {
        $zone_id = $request->zone_id;
        $cartItems = json_decode($request->cart);

        $ids = [];
        $total_amount = 0;
        foreach ($cartItems as $product) {
            array_push($ids, $product->productId);
        }

        $products = Product::whereIn('id', $ids)->with('sizes')->get();  // Updated: Load sizes

        $total_weight = 0;
        foreach ($products as $product) {

            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $price = $product->getPrice();  // Default

                    if (property_exists($prod, 'sizeId') && $prod->sizeId) {
                        $size = $product->sizes->firstWhere('id', $prod->sizeId);
                        if ($size) {
                            $price = $size->price;  // NEW: Use size price if available
                        }
                    }

                    // Safely handle null/zero weights: use 0 if weight is null or invalid
                    $productWeight = ($product->weight && $product->weight > 0) ? $product->weight : 0;
                    $total_weight += $prod->quantity * $productWeight;
                    $total_amount += $price * $prod->quantity;
                }
            }
        }

        // Calculate shipping using tiered pricing
        $shippingCalculation = $this->calculateTieredShipping($zone_id, $total_weight);

        if (!$shippingCalculation) {
            $total_shipping = 0;
        } else {
            $total_shipping = $shippingCalculation['rate'];
        }

        // Check if customer is first-time (need email from request or session)
        $customerEmail = $request->input('email');
        $address = null;
        if (!$customerEmail) {
            // Try to get from session address
            $guestAddressId = Session::get('guest_billing_address_id');
            if ($guestAddressId) {
                $address = Address::with('country')->find($guestAddressId);
                $customerEmail = $address ? $address->email : null;
            }
        } else {
            // If email provided, try to get address from session
            $guestAddressId = Session::get('guest_billing_address_id');
            if ($guestAddressId) {
                $address = Address::with('country')->find($guestAddressId);
            }
        }

        // Calculate discount if first-time customer
        $isFirstOrder = $this->isFirstTimeCustomer($customerEmail);
        $discountAmount = 0;
        $discountedSubtotal = $total_amount;
        if ($isFirstOrder) {
            $discountData = $this->calculateFirstOrderDiscount($total_amount);
            $discountAmount = $discountData['discount_amount'];
            $discountedSubtotal = $discountData['discounted_subtotal'];
        }

        // Check for free shipping (Spain orders over €70)
        if ($this->qualifiesForFreeShipping($address, $discountedSubtotal)) {
            $total_shipping = 0;
        }

        // Calculate grand total with discount
        $grand_total = $total_shipping + $discountedSubtotal;

        return json_encode([
            'subtotal' => number_format($total_amount, 2),
            'discount_amount' => number_format($discountAmount, 2),
            'discounted_subtotal' => number_format($discountedSubtotal, 2),
            'is_first_order' => $isFirstOrder,
            'total_shipping' => app_currency() . ' ' . number_format($total_shipping, 2),
            'grand_total' => app_currency() . ' ' . number_format($grand_total, 2),
            'total_weight' => $total_weight,
            'breakdown' => $shippingCalculation['breakdown'] ?? []
        ]);
    }

    /**
     * Validate cart weight against shipping zone maximum weight limit
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCartWeight(Request $request)
    {
        $zone_id = $request->zone_id;
        $cartItems = json_decode($request->cart, true);

        if (!$zone_id || !$cartItems) {
            return response()->json([
                'valid' => false,
                'message' => 'Missing zone_id or cart data'
            ], 400);
        }

        $ids = [];
        foreach ($cartItems as $product) {
            array_push($ids, $product['productId']);
        }

        $products = Product::whereIn('id', $ids)->with('sizes')->get();

        $total_weight = 0;
        foreach ($products as $product) {
            foreach ($cartItems as $prod) {
                if ($prod['productId'] == $product->id) {
                    $productWeight = ($product->weight && $product->weight > 0) ? $product->weight : 0;
                    $quantity = $prod['quantity'] ?? 1;
                    $total_weight += $quantity * $productWeight;
                }
            }
        }

        $maxWeight = $this->getMaxWeightForZone($zone_id);

        if (!$maxWeight) {
            return response()->json([
                'valid' => false,
                'message' => 'No shipping rates found for this zone'
            ], 400);
        }

        $weightExceeded = $total_weight > $maxWeight;

        return response()->json([
            'valid' => !$weightExceeded,
            'total_weight' => $total_weight,
            'max_weight' => $maxWeight,
            'weight_exceeded' => $weightExceeded,
            'message' => $weightExceeded
                ? "Cannot proceed: Total cart weight ({$total_weight}g) exceeds the maximum allowed weight ({$maxWeight}g) for this shipping zone. Please remove some items."
                : "Cart weight ({$total_weight}g) is within the allowed limit ({$maxWeight}g)."
        ]);
    }
    /**
     * Process cart data (e.g., from client-side localStorage) and store it in session, then redirect to checkout.
     * This method is typically called via a POST request from your cart page.
     */
    public function processCartAndShowCheckout(Request $request)
    {
        $request->validate([
            'cart_data' => 'required|json',
        ]);

        $cartDataJson = $request->input('cart_data');
        $cartItems = json_decode($cartDataJson, true);

        // Store cart items in the session
        Session::put('current_cart_for_checkout', $cartItems);

        // Optionally, clear any old guest address ID if starting a fresh checkout
        // Session::forget('guest_billing_address_id');

        // Redirect to the GET route for the checkout page
        return redirect()->route('web.checkoutDetails');
        //       return response()->json([
        //     'success' => true,
        //     'message' => 'Cart data processed and stored in session.',
        //     'redirect_url' => route('web.checkoutDetails') // Optionally return the redirect URL
        // ]);
    }

    /**
     * Store or update the guest's billing address.
     */
    public function storeAddress(Request $request)
    {
        // Get country to check if Spain (for conditional validation)
        $countryId = $request->country;
        $country = \App\Models\Country::find($countryId);
        $isSpain = $country && strtolower(trim($country->name)) === 'spain';

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'country' => 'required|string|min:1',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'region' => 'required|string|min:1',
            'postcode' => 'required|string|max:20',
            'from_where' => 'required',
            'product_id' => 'nullable',
            'email' => 'required|email',
            'city' => $isSpain ? 'required|string|max:255' : 'nullable|string|max:255',
            'province' => $isSpain ? 'required|string|max:255' : 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);

        // Check if an address ID already exists in the session (meaning they're editing)
        $guestAddressId = Session::get('guest_billing_address_id');
        if ($guestAddressId) {
            $address = Address::find($guestAddressId);
            if ($address) {
                // Update existing address
                $address->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'mobile_number' => $request->mobile_number,
                    'country_id' => $request->country,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'province' => $request->province,
                    'shipping_zone_id' => $request->region,
                    'county' => NULL,
                    'postcode' => $request->postcode,
                    'email' => $request->email
                ]);
                Session::flash('success', 'Address updated successfully!');
            } else {
                // Address not found, create a new one
                $address = Address::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'mobile_number' => $request->mobile_number,
                    'country_id' => $request->country,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'province' => $request->province,
                    'shipping_zone_id' => $request->region,
                    'county' => NULL,
                    'postcode' => $request->postcode,
                    'email' => $request->email
                ]);
                Session::put('guest_billing_address_id', $address->id);
                Session::flash('success', 'New address saved successfully!');
            }
        } else {
            // No existing address ID, create a new address
            $address = Address::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'country_id' => $request->country,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => NULL,
                'shipping_zone_id' => $request->region,
                'county' => NULL,
                'postcode' => $request->postcode,
                'email' => $request->email
            ]);
            Session::put('guest_billing_address_id', $address->id);
            Session::flash('success', 'Address saved successfully!');
        }

        // Redirect back to the checkout page, removing the edit_address parameter
        if ($request->from_where == 'single') {
            return redirect()->route('web.checkoutDetails.single', [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size_id' => $request->size_id ?? 0
            ]);
        }
        return redirect()->route('web.checkoutDetails');
    }




    public function stripeSuccess(Request $request)
    {

        $sessionId = $request->get('session_id');

        if ($sessionId) {
            try {
                $session = StripeSession::retrieve($sessionId);


                // $paymentIntent = \Stripe\PaymentIntent::retrieve(
                //     $session->payment_intent,
                //     ['expand' => ['payment_method']]
                // );

                // $paymentMethod = $paymentIntent->payment_method;

                // You can access session data here
                $paymentStatus = $session->payment_status;
                $amountTotal = $session->amount_total;
                $currency = $session->currency;
                $metadata = $session->metadata;


                // $paymentIntent = $session->payment_intent;
                // $paymentMethod = $paymentIntent->payment_method;

                $paymentMethod = "Stripe";

                Payment::firstOrCreate(
                    [
                        'stripe_session_id' => $session['id'], // Search criteria
                    ],
                    [
                        // Data to create if not found
                        'user_id' => null,
                        'order_id' => $metadata->order_id,
                        'amount' => $session['amount_total'] / 100,
                        'currency' => $session['currency'],
                        'status' => 'completed',
                        'payment_method' => $paymentMethod,
                    ]
                );

                $order = Order::with(['billingAddress', 'orderProducts'])->where('id', '=', $metadata->order_id)->first();


                // $order = Order::find($metadata->order_id);
                $order->payment_status = 'paid';
                $order->save();

                foreach ($order->orderProducts as $oneProduct) {
                    $product = Product::find($oneProduct->product_id);
                    $product->quantity -= $oneProduct->quantity;
                    $product->save();
                }

                $name = $order->billingAddress->first_name . ' ' . $order->billingAddress->last_name;
                $email = $order->billingAddress->email;


                $data = [
                    'customer_name' => $name,
                    'order_id' => $order->order_number,
                    'amount' => number_format($session->amount_total / 100, 2),
                    'payment_method' => $paymentMethod,
                    'payment_time' => date("Y-m-d H:i:s")
                ];

                $data2 = [
                    'customer_name' => $name,
                    'order_id' => $order->order_number,
                    'amount' => number_format($session->amount_total / 100, 2),
                    'payment_method' => $paymentMethod,
                ];

                // Send payment confirmation email to admin
                $adminEmail = config('app.admin_email');
                if ($adminEmail) {
                    try {
                        Mail::to($adminEmail)->send(new PaymentMail($data));
                        Log::info('Payment confirmation email sent to admin for order #' . $order->order_number . ' with mail: ' . $adminEmail);
                    } catch (\Exception $e) {
                        Log::error('Failed to send payment confirmation email: ' . $e->getMessage());
                        // Fallback to queue
                        Mail::to($adminEmail)->queue(new PaymentMail($data));
                    }
                }

                // Send order notification email to admin (when payment is confirmed)
                $orderData = [
                    'customer_name' => $name,
                    'customer_email' => $email,
                    'order_id' => $order->order_number,
                    'total' => number_format($session->amount_total / 100, 2),
                    'estimated_delivery_date' => '2025-07-05',
                    'order_time' => date('Y-m-d H:i:s')
                ];

                if ($adminEmail) {
                    try {
                        Mail::to($adminEmail)->send(new \App\Mail\OrderMail($orderData));
                        // add actual mail to the logs
                        Log::info('Order notification email sent to admin for order #' . $order->order_number . ' with mail: ' . $adminEmail);
                    } catch (\Exception $e) {
                        Log::error('Failed to send order notification email: ' . $e->getMessage());
                        // Fallback to queue
                        Mail::to($adminEmail)->queue(new \App\Mail\OrderMail($orderData));
                    }
                }

                // Send receipt to customer
                Mail::to($email)->queue(new ReceiptMail($data2));


                return view('frontend.partials.stripeSuccess', compact('session'));

            } catch (\Exception $e) {
                // dd($e->getMessage());
                Log::error('Error retrieving session: ' . $e->getMessage());
                return redirect()->route('checkout.cancel.stripe');
            }

        }



    }

    public function stripeCancel(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            $session = StripeSession::retrieve($sessionId);

            // You can access session data here
            $paymentStatus = $session->payment_status;
            $amountTotal = $session->amount_total;
            $currency = $session->currency;
            $metadata = $session->metadata;

            // Payment::create([
            //     'stripe_session_id' => $session['id'],
            //     'user_id' => null,
            //     'order_id' => $metadata->order_id,
            //     'amount' => $session['amount_total'],
            //     'currency' => $session['currency'],
            //     'status' => 'failed',
            //     'payment_method' => 'stripe',
            // ]);

            Payment::firstOrCreate(
                [
                    'stripe_session_id' => $session['id'], // Search criteria
                ],
                [
                    // Data to create if not found
                    'user_id' => null,
                    'order_id' => $metadata->order_id,
                    'amount' => $session['amount_total'] / 100,
                    'currency' => $session['currency'],
                    'status' => 'failed',
                    'payment_method' => 'stripe',
                ]
            );
        }


        return view('frontend.partials.stripeCancel');
    }


    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook.secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            // Log::error('Invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Log::error('Invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event['type']) {
            case 'checkout.session.completed':
                $session = $event['data']['object'];
                $this->handleSuccessfulPayment($session);
                break;

            case 'payment_intent.succeeded':
                $paymentIntent = $event['data']['object'];
                // Log::info('Payment succeeded: ' . $paymentIntent['id']);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event['data']['object'];
                // Log::warning('Payment failed: ' . $paymentIntent['id']);
                break;

            default:
            // Log::info('Received unknown event type: ' . $event['type']);
        }

        return response()->json(['status' => 'success']);
    }


    private function handleSuccessfulPayment($session)
    {
        // Extract metadata
        $userId = $session['metadata']['user_id'] ?? null;
        $orderId = $session['metadata']['order_id'] ?? null;



        Payment::firstOrCreate(
            [
                'stripe_session_id' => $session['id'], // Search criteria
            ],
            [
                // Data to create if not found
                'user_id' => null,
                'order_id' => $orderId,
                'amount' => $session['amount_total'] / 100,
                'currency' => $session['currency'],
                'status' => 'completed',
                'payment_method' => 'stripe',
            ]
        );

        $order = Order::with('billingAddress')->find($orderId);
        if ($order) {
            $order->payment_status = 'paid';
            $order->save();

            // Send order notification email to admin when payment is confirmed via webhook
            $adminEmail = config('app.admin_email');
            if ($adminEmail && $order->billingAddress) {
                try {
                    $orderData = [
                        'customer_name' => $order->billingAddress->first_name . ' ' . $order->billingAddress->last_name,
                        'customer_email' => $order->billingAddress->email,
                        'order_id' => $order->order_number,
                        'total' => number_format($session['amount_total'] / 100, 2),
                        'estimated_delivery_date' => '2025-07-05',
                        'order_time' => date('Y-m-d H:i:s')
                    ];

                    Mail::to($adminEmail)->send(new \App\Mail\OrderMail($orderData));
                    Log::info('Order notification email sent to admin via webhook for order #' . $order->order_number);
                } catch (\Exception $e) {
                    Log::error('Failed to send order notification email via webhook: ' . $e->getMessage());
                    // Fallback to queue
                    try {
                        Mail::to($adminEmail)->queue(new \App\Mail\OrderMail($orderData));
                    } catch (\Exception $queueException) {
                        Log::error('Failed to queue order notification email via webhook: ' . $queueException->getMessage());
                    }
                }
            }
        }
    }

    private function handleFailedPayment($session)
    {
        // Extract metadata
        $userId = $session['metadata']['user_id'] ?? null;
        $orderId = $session['metadata']['order_id'] ?? null;



        Payment::firstOrCreate(
            [
                'stripe_session_id' => $session['id'], // Search criteria
            ],
            [
                // Data to create if not found
                'user_id' => null,
                'order_id' => $orderId,
                'amount' => $session['amount_total'] / 100,
                'currency' => $session['currency'],
                'status' => 'failed',
                'payment_method' => 'stripe',
            ]
        );
    }

    // You will need a method to finalize the order later,
    // which would retrieve guest_billing_address_id from session,
    // retrieve cart_items from session, and then create a new Order
    // record linking to the billing_address_id.
    // Example (conceptual):
    /*
    public function placeOrder(Request $request)
    {
        $cartItems = Session::get('current_cart_for_checkout');
        $billingAddressId = Session::get('guest_billing_address_id');

        if (!$cartItems || !$billingAddressId) {
            return redirect()->route('web.checkoutDetails')->with('error', 'Cart or billing address missing.');
        }

        $productSubtotal = 0;
        foreach ($cartItems as $item) {
            $productSubtotal += ($item['price'] * $item['quantity']);
        }
        $deliveryFee = 15.99; // Or dynamic calculation
        $totalAmount = $productSubtotal + $deliveryFee;

        $order = Order::create([
            'billing_address_id' => $billingAddressId,
            'subtotal' => $productSubtotal,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalAmount,
            'status' => 'pending', // Initial status
        ]);

        // Optionally, create order items linking to the products in $cartItems

        Session::forget('current_cart_for_checkout'); // Clear cart
        Session::forget('guest_billing_address_id'); // Clear address from session

        return redirect()->route('web.order.confirmation', ['order' => $order->id])->with('success', 'Order placed successfully!');
    }
    */
}