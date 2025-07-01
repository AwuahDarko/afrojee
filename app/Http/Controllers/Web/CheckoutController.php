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
use App\Models\Order;   // Import the Order model (for future use, if not already used)
use Illuminate\Support\Facades\Session; // Import Session facade
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
     * Display the checkout page with guest's address and cart details.
     */
    public function index(Request $request)
    {
        $userAddress = null;
        $cartItems = json_decode($request->cart);

        $scountries = Country::where('status', '=', 1)->get();

        // Try to retrieve the address ID from the session for guests
        $guestAddressId = Session::get('guest_billing_address_id');

        if ($guestAddressId) {
            $userAddress = Address::find($guestAddressId);
        }

        // Get cart items from the session (as implemented previously)
        // $cartItems = Session::get('current_cart_for_checkout', []);

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
        $product = Product::find($request->product_id);


        $userAddress = null;

        // Try to retrieve the address ID from the session for guests
        $guestAddressId = Session::get('guest_billing_address_id');

        if ($guestAddressId) {
            $userAddress = Address::find($guestAddressId);
        }

        // Get cart items from the session (as implemented previously)
        $cartItems = Session::get('current_cart_for_checkout', []);

        return view('frontend.partials.checkoutDetailsSingle', [
            'editingAddress' => $request->has('edit_address'),
            'userAddress' => $userAddress, // This will be an Address model instance or null
            'cartItems' => $cartItems,
            'countries' => $scountries,
            'product' => $product,
            'quantity' => $request->quantity
        ]);
    }

    public function getRegionByCountry(Request $request)
    {


        $zones = ShippingZone::where('country_id', $request->country_id)->get();


        return view('frontend.partials.zone-option', compact('zones'));
    }


    public function calculatePrice(Request $request)
    {
        $quantity = $request->qty;
        $product_id = $request->id;
        $zone_id = $request->zone_id;

        // get product details
        $product = Product::findOrFail($product_id);
        $weight = $product->weight * $quantity;

        // $rate = ShippingRate::where(['shipping_zone_id', '=', $zone_id)->get();
        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->where('weight_from', '<=', $weight)
            ->where('weight_to', '>=', $weight)
            ->first();

        // dd($rates);

        $total_price = $product->price * $quantity;
        $total_shipping = $rates->rate;
        $grand_total = $total_shipping + $total_price;



        return view('frontend.partials.checkoutSummary', compact('total_price', 'total_shipping', 'grand_total'));
    }

    public function getPrice(Request $request)
    {
        // $quantity = $request->qty;
        // $product_id = $request->id;
        $zone_id = $request->zone_id;
        $cartItems = json_decode($request->cart);

        $ids = [];
        $total_amount = 0;
        foreach ($cartItems as $product) {
            array_push($ids, $product->productId);
        }

        $products = Product::whereIn('id', $ids)->get();

        $total_weight = 0;
        foreach ($products as $product) {

            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $total_weight += $prod->quantity * $product->weight;
                    $total_amount += $product->price * $prod->quantity;

                }
            }
        }


        // $rate = ShippingRate::where(['shipping_zone_id', '=', $zone_id)->get();
        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->where('weight_from', '<=', $total_weight)
            ->where('weight_to', '>=', $total_weight)
            ->first();

        // dd($rates);

        // $total_price = $product->price * $quantity;
        $total_shipping = $rates->rate ?? 200;
        // $grand_total = $total_shipping + $total_price;


        return json_encode([
            'total_shipping' => app_currency(). ' '. number_format($total_shipping, 2),
            'grand_total' => app_currency(). ' '. number_format($total_shipping + $total_amount, 2)
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
        $validatedData = $request->validate([
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
            'email' => 'required|email'
        ]);

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
                    'city' => NULL,
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
                    'city' => NULL,
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
            return redirect()->route('web.checkoutDetails.single', ['product_id' => $request->product_id, 'quantity' => $request->quantity]);
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
                        'amount' => $session['amount_total']/100,
                        'currency' => $session['currency'],
                        'status' => 'completed',
                        'payment_method' => $paymentMethod,
                    ]
                );

                $order = Order::with(['billingAddress', 'orderProducts'])->where('id', '=', $metadata->order_id)->first();

                
                // $order = Order::find($metadata->order_id);
                $order->payment_status = 'paid';
                $order->save();
                
                foreach($order->orderProducts as $oneProduct){
                    $product = Product::find($oneProduct->product_id);
                    $product->quantity -= $oneProduct->quantity;
                    $product->save();
                }
                
                $name = $order->billingAddress->first_name . ' ' . $order->billingAddress->last_name;
                $email = $order->billingAddress->email;
             

                $data = [
                    'customer_name' => $name,
                    'order_id' => $order->order_number,
                    'amount' => number_format($session->amount_total/100, 2),
                    'payment_method' => $paymentMethod,
                    'payment_time' => date("Y-m-d H:i:s")
                ];

                $data2 = [
                    'customer_name' => $name,
                    'order_id' => $order->order_number,
                    'amount' => number_format($session->amount_total/100, 2),
                    'payment_method' => $paymentMethod,
                ];


                Mail::to(env('ADMIN_EMAIL'))->queue(new PaymentMail($data));
                Mail::to($email)->queue(new ReceiptMail($data2));


                return view('frontend.partials.stripeSuccess', compact('session'));

            } catch (\Exception $e) {
                // dd($e->getMessage());
                \Log::error('Error retrieving session: ' . $e->getMessage());
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
                    'amount' => $session['amount_total']/100,
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
                'amount' => $session['amount_total']/100,
                'currency' => $session['currency'],
                'status' => 'completed',
                'payment_method' => 'stripe',
            ]
        );

        $order = Order::find($orderId);
        $order->payment_status = 'paid';
        $order->save();
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
                'amount' => $session['amount_total']/100,
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