<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Address;
use App\Models\Product;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderMail;

class OrderController extends Controller
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Display a summary of a customer's order by order number.
     *
     * @param  string  $orderNumber
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show(string $orderNumber)
    {
        $order = Order::with([
            'orderProducts.product',
            'orderProducts.size',
            'billingAddress',
            'shippingAddress',
        ])
            ->where('order_number', $orderNumber)
            ->first();

        if (!$order) {
            abort(404);
        }

        $billingAddress = $order->billingAddress;
        $shippingAddress = $order->shippingAddress ?: $billingAddress;

        return view('frontend.orders.show', [
            'order' => $order,
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Check if customer is making their first order (by email)
     * 
     * @param string $email
     * @return bool
     */
    private function isFirstTimeCustomer($email)
    {
        if (!$email) {
            return false;
        }

        // Check if there are any paid orders with this email
        $existingOrders = Order::whereHas('billingAddress', function ($query) use ($email) {
            $query->where('email', $email);
        })->where('payment_status', 'paid')->exists();

        return !$existingOrders;
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
     * Send order notification email to admin
     * 
     * @param Order $order
     * @param Address $address
     * @param float $grand_total
     * @return void
     */
    private function sendOrderNotification($order, $address, $grand_total)
    {
        $adminEmail = config('app.admin_email');
        
        if (!$adminEmail) {
            Log::warning('ADMIN_EMAIL not configured. Order notification not sent for order #' . $order->order_number);
            return;
        }

        try {
            $data = [
                'customer_name' => $address->first_name . ' ' . $address->last_name,
                'customer_email' => $address->email,
                'order_id' => $order->order_number,
                'total' => number_format($grand_total, 2),
                'estimated_delivery_date' => '2025-07-05',
                'order_time' => date('Y-m-d H:i:s')
            ];

            // Use send() for immediate delivery instead of queue()
            Mail::to($adminEmail)->send(new OrderMail($data));
            Log::info('Order notification email sent to admin for order #' . $order->order_number . ' with mail: ' . $adminEmail);
        } catch (\Exception $e) {
            Log::error('Failed to send order notification email for order #' . $order->order_number . ': ' . $e->getMessage());
            // Try to send via queue as fallback
            try {
                Mail::to($adminEmail)->queue(new OrderMail($data));
                Log::info('Order notification email queued as fallback for order #' . $order->order_number);
            } catch (\Exception $queueException) {
                Log::error('Failed to queue order notification email for order #' . $order->order_number . ': ' . $queueException->getMessage());
            }
        }
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:1',
            'zone_id' => 'required|numeric|min:1',
            'size_id' => 'nullable|numeric|min:0',  // NEW: Validate size_id
        ]);

        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $zone_id = $request->zone_id;
        $size_id = $request->size_id !== null ? (int) $request->size_id : null;  // NEW
        $guestAddressId = Session::get('guest_billing_address_id');

        $product = Product::with('sizes')->findOrFail($product_id);  // Updated: Load sizes

        $price = $product->getPrice();
        $weight = $product->weight;

        if ($size_id) {
            $size = $product->sizes->firstWhere('id', $size_id);
            if ($size) {
                $price = $product->getPriceForSize($size_id);  // Apply discount to size price
            }
        }

        $subtotal = $price * $quantity;

        // Get customer email to check if first-time customer
        $address = Address::find($guestAddressId);
        $customerEmail = $address ? $address->email : null;
        $isFirstOrder = $this->isFirstTimeCustomer($customerEmail);

        // Apply first order discount (10%)
        $discountAmount = 0;
        $discountedSubtotal = $subtotal;
        if ($isFirstOrder) {
            $discountData = $this->calculateFirstOrderDiscount($subtotal);
            $discountAmount = $discountData['discount_amount'];
            $discountedSubtotal = $discountData['discounted_subtotal'];
        }

        // Safely handle null/zero weights
        $productWeight = ($product->weight && $product->weight > 0) ? $product->weight : 0;
        $weight = $productWeight * $quantity;  // Weight product-level

        // Validate that we have some weight before calculating shipping
        if ($weight <= 0) {
            return back()->withErrors([
                'shipping' => 'Unable to calculate shipping cost. This product has invalid or missing weight information.'
            ])->withInput();
        }

        $rates = $this->getShippingRate($zone_id, $weight);

        // If no rate found, redirect back with error
        if (!$rates) {
            return back()->withErrors([
                'shipping' => 'Unable to calculate shipping cost. Please verify your shipping address and ensure products have valid weight.'
            ])->withInput();
        }

        $delivery_fee = $rates->rate;

        // Calculate grand total with discount applied
        $grand_total = $delivery_fee + $discountedSubtotal;

        $orderNo = "AFR" . rand(111111111, 999999999);

        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => $orderNo,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'is_first_order' => $isFirstOrder,
                'delivery_fee' => $delivery_fee,
                'total_weight' => $weight,
                'total_amount' => $grand_total,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'shipping_address_id' => $guestAddressId, // Use same address as billing, or null if not provided
            ]
        );

        $orderProduct = OrderProduct::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'size_id' => $size_id,  // NEW: Save size_id
            'quantity' => $quantity,
            'unit_price' => $price,
            'total_price' => $price * $quantity,
            'unit_weight' => $product->weight,
            'total_weight' => $product->weight * $quantity,
        ]);

        $address = Address::find($guestAddressId);

        // Send order notification email to admin
        $this->sendOrderNotification($order, $address, $grand_total);

        $session = StripeSession::create(
            [
                'payment_method_types' => [
                    'card',           // Credit/debit cards
                    //'sepa_debit',     // SEPA Direct Debit
                    'ideal',          // Netherlands
                    'bancontact',     // Belgium  
                    'eps',            // Austria
                    'p24',            // Poland
                    'klarna'          // Buy now, pay later
                ],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => $product->name ?? 'Afro Jee Product',
                                'description' => "Purchase of {$quantity} {$product->name}",
                            ],
                            'unit_amount' => $grand_total * 100, // Amount in cents
                        ],
                        'quantity' => 1// $quantity ?? 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('checkout.success.stripe', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel.stripe', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'user_id' => 'guest',
                    'order_id' => $order->id ?? 0,
                ],
            ]
        );

        return redirect()->away($session->url);
    }

    public function storeMultiple(Request $request)
    {
        $validatedData = $request->validate([
            'cart' => 'required|string',
            'zone_id' => 'required|numeric|min:1',
        ]);

        $cartItems = json_decode($request->cart);
        $zone_id = $request->zone_id;

        $ids = [];
        foreach ($cartItems as $product) {
            array_push($ids, $product->productId);
        }

        $products = Product::whereIn('id', $ids)->with('sizes')->get();  // Updated: Load sizes

        $total_weight = 0;
        $total_amount = 0;
        foreach ($products as $product) {

            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $price = $product->getPrice();  // Default

                    if (property_exists($prod, 'sizeId') && $prod->sizeId) {
                        $size = $product->sizes->firstWhere('id', $prod->sizeId);
                        if ($size) {
                            $price = $product->getPriceForSize($prod->sizeId);  // Apply discount to size price
                        }
                    }

                    // Safely handle null/zero weights: use 0 if weight is null or invalid
                    $productWeight = ($product->weight && $product->weight > 0) ? $product->weight : 0;
                    $total_weight += $prod->quantity * $productWeight;
                    $total_amount += $price * $prod->quantity;
                }
            }
        }

        // Validate that we have some weight before calculating shipping
        if ($total_weight <= 0) {
            return back()->withErrors([
                'shipping' => 'Unable to calculate shipping cost. One or more products in your cart have invalid or missing weight information.'
            ])->withInput();
        }

        // Calculate shipping using tiered pricing (no longer blocking excess weight)
        $shippingCalculation = $this->calculateTieredShipping($zone_id, $total_weight);

        if (!$shippingCalculation) {
            return back()->withErrors([
                'shipping' => 'Unable to calculate shipping cost. Please verify your shipping address and ensure products have valid weight.'
            ])->withInput();
        }

        $rates = (object) ['rate' => $shippingCalculation['rate']];

        $guestAddressId = Session::get('guest_billing_address_id');

        // If no rate found, redirect back with error
        if (!$rates) {
            return back()->withErrors([
                'shipping' => 'Unable to calculate shipping cost. Total weight may be invalid or exceed maximum allowed weight for this shipping zone.'
            ])->withInput();
        }

        $delivery_fee = $rates->rate;

        // Get customer email to check if first-time customer
        $address = Address::find($guestAddressId);
        $customerEmail = $address ? $address->email : null;
        $isFirstOrder = $this->isFirstTimeCustomer($customerEmail);

        // Apply first order discount (10%)
        $discountAmount = 0;
        $discountedSubtotal = $total_amount;
        if ($isFirstOrder) {
            $discountData = $this->calculateFirstOrderDiscount($total_amount);
            $discountAmount = $discountData['discount_amount'];
            $discountedSubtotal = $discountData['discounted_subtotal'];
        }

        // Calculate grand total with discount applied
        $grand_total = $delivery_fee + $discountedSubtotal;

        $orderNo = "AFR" . rand(111111111, 999999999);

        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => $orderNo,
                'subtotal' => $total_amount,
                'discount_amount' => $discountAmount,
                'is_first_order' => $isFirstOrder,
                'delivery_fee' => $delivery_fee,
                'total_weight' => $total_weight,
                'total_amount' => $grand_total,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'shipping_address_id' => $guestAddressId, // Use same address as billing, or null if not provided
            ]
        );

        $quantity = 0;
        foreach ($products as $product) {

            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $price = $product->getPrice();  // Default

                    if (property_exists($prod, 'sizeId') && $prod->sizeId) {
                        $size = $product->sizes->firstWhere('id', $prod->sizeId);
                        if ($size) {
                            $price = $product->getPriceForSize($prod->sizeId);  // Apply discount to size price
                        }
                    }

                    $orderProduct = OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'size_id' => $prod->sizeId ?? null,  // NEW: Save size_id
                        'quantity' => $prod->quantity,
                        'unit_price' => $price,
                        'total_price' => $price * $prod->quantity,
                        'unit_weight' => $product->weight,
                        'total_weight' => $product->weight * $prod->quantity,
                    ]);

                    $quantity += $prod->quantity;
                }
            }
        }

        $total_items = count($products);

        $address = Address::find($guestAddressId);

        // Send order notification email to admin
        $this->sendOrderNotification($order, $address, $grand_total);

        $session = StripeSession::create(
            [
                'payment_method_types' => [
                    'card',           // Credit/debit cards
                    //'sepa_debit',     // SEPA Direct Debit
                    'ideal',          // Netherlands
                    'bancontact',     // Belgium  
                    'eps',            // Austria
                    'p24',            // Poland
                    'klarna'          // Buy now, pay later
                ],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => 'Purchases from Afro Jee',
                                'description' => "Purchase of {$total_items} items",
                            ],
                            'unit_amount' => $grand_total * 100, // Amount in cents
                        ],
                        'quantity' => 1//$quantity ?? 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('checkout.success.stripe', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel.stripe', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'user_id' => 'guest',
                    'order_id' => $order->id ?? 0,
                ],
            ]
        );

        return redirect()->away($session->url);
    }
}
