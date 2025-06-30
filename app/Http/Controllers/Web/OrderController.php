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



class OrderController extends Controller
{
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


        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => rand(111111111, 999999999),
                'subtotal' => $subtotal,
                'delivery_fee' => $delivery_fee,
                'total_weight' => $weight,
                'total_amount' => $delivery_fee + $subtotal,
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


        // TODO ==== remove this ===
        return redirect()->route('web.checkoutDetails.single', ['product_id' => $request->product_id, 'quantity' => $request->quantity]);
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

        $order = Order::create(
            [
                'user_id' => 0,
                'billing_address_id' => $guestAddressId ?? 0,
                'order_number' => rand(111111111, 999999999),
                'subtotal' => $total_amount,
                'delivery_fee' => $rates->rate,
                'total_weight' => $total_weight,
                'total_amount' => $rates->rate + $total_amount,
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'shipping_address_id' => $zone_id ?? 0,
            ]
        );

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
                }
            }
        }


        return redirect()->route('web.checkoutDetails');


    }
}
