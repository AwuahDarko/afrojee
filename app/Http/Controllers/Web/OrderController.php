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
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;


class OrderController extends Controller
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:1',
            'zone_id' => 'required|numeric|min:1',

        ]);

        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $zone_id = $request->zone_id;
        $guestAddressId = Session::get('guest_billing_address_id');

        $product = Product::findOrFail($product_id);
        $subtotal = $product->price * $quantity;
        $weight = $product->weight * $quantity;

        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->where('weight_from', '<=', $weight)
            ->where('weight_to', '>=', $weight)
            ->first();

        $delivery_fee = $rates->rate;

        $grand_total = $delivery_fee + $subtotal;


        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => rand(111111111, 999999999),
                'subtotal' => $subtotal,
                'delivery_fee' => $delivery_fee,
                'total_weight' => $weight,
                'total_amount' => $grand_total,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'shipping_address_id' => $zone_id ?? 0,
            ]
        );

        $orderProduct = OrderProduct::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'total_price' => $product->price * $quantity,
            'unit_weight' => $product->weight,
            'total_weight' => $product->weight * $quantity,
        ]);


        $session = StripeSession::create(
            [
                'payment_method_types' => [
                    'card',           // Credit/debit cards
                    'sepa_debit',     // SEPA Direct Debit
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
                        'quantity' => $quantity ?? 1,
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

        $products = Product::whereIn('id', $ids)->get();

        $total_weight = 0;
        $total_amount = 0;
        foreach ($products as $product) {


            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $total_weight += $prod->quantity * $product->weight;
                    $total_amount += $product->price * $prod->quantity;
                }
            }
        }


        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->where('weight_from', '<=', $total_weight)
            ->where('weight_to', '>=', $total_weight)
            ->first();


        $guestAddressId = Session::get('guest_billing_address_id');

        $grand_total = $rates->rate + $total_amount;

        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => rand(111111111, 999999999),
                'subtotal' => $total_amount,
                'delivery_fee' => $rates->rate,
                'total_weight' => $total_weight,
                'total_amount' => $grand_total,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'shipping_address_id' => $zone_id ?? 0,
            ]
        );

        $quantity = 0;
        foreach ($products as $product) {

            for ($i = 0; $i < count($cartItems); ++$i) {
                $prod = $cartItems[$i];
                if ($prod->productId == $product->id) {
                    $orderProduct = OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $prod->quantity,
                        'unit_price' => $product->price,
                        'total_price' => $product->price * $prod->quantity,
                        'unit_weight' => $product->weight,
                        'total_weight' => $product->weight * $prod->quantity,
                    ]);

                    $quantity += $prod->quantity;
                }
            }
        }

        $total_items = count($products);

        $session = StripeSession::create(
            [
                'payment_method_types' => [
                    'card',           // Credit/debit cards
                    'sepa_debit',     // SEPA Direct Debit
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
                        'quantity' => $quantity ?? 1,
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
