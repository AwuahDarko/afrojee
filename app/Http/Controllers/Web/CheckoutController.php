<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Product;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use App\Models\Address; // Import the Address model
use App\Models\Order;   // Import the Order model (for future use, if not already used)
use Illuminate\Support\Facades\Session; // Import Session facade

class CheckoutController extends Controller
{
    /**
     * Display the checkout page with guest's address and cart details.
     */
    public function index(Request $request)
    {
        $userAddress = null;

        // Try to retrieve the address ID from the session for guests
        $guestAddressId = Session::get('guest_billing_address_id');

        if ($guestAddressId) {
            $userAddress = Address::find($guestAddressId);
        }

        // Get cart items from the session (as implemented previously)
        $cartItems = Session::get('current_cart_for_checkout', []);

        return view('frontend.partials.checkoutDetails', [
            'editingAddress' => $request->has('edit_address'),
            'userAddress' => $userAddress, // This will be an Address model instance or null
            'cartItems' => $cartItems,
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
            'product' => $product
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
        $weight = $product->weight;

        // $rate = ShippingRate::where(['shipping_zone_id', '=', $zone_id)->get();
        $rates = ShippingRate::where('shipping_zone_id', $zone_id)
            ->where('weight_from', '<=', $weight)
            ->where('weight_to', '>=', $weight)
            ->first();

            // dd($rates);

        $total_price = $product->price * $quantity;
        $total_shipping = $rates->rate * $quantity;
        $grand_total = $total_shipping + $total_price;



        return view('frontend.partials.checkoutSummary', compact('total_price', 'total_shipping', 'grand_total'));
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
            'product_id' => 'nullable'
        ]);

        // Check if an address ID already exists in the session (meaning they're editing)
        $guestAddressId = Session::get('guest_billing_address_id');
        if ($guestAddressId) {
            $address = Address::find($guestAddressId);
            if ($address) {
                // Update existing address
                $address->update([
                    'first_name' => $request->first_name, 
                    'last_name' =>  $request->last_name, 
                    'mobile_number' =>  $request->mobile_number, 
                    'country_id' =>  $request->country, 
                    'address_line_1' =>  $request->address_line_1, 
                    'address_line_2' =>  $request->address_line_2, 
                    'city' => NULL, 
                    'shipping_zone_id' =>  $request->region, 
                    'county' => NULL, 
                    'postcode' =>  $request->postcode, 
                ]);
                Session::flash('success', 'Address updated successfully!');
            } else {
                // Address not found, create a new one
                $address = Address::create([
                    'first_name' => $request->first_name, 
                    'last_name' =>  $request->last_name, 
                    'mobile_number' =>  $request->mobile_number, 
                    'country_id' =>  $request->country, 
                    'address_line_1' =>  $request->address_line_1, 
                    'address_line_2' =>  $request->address_line_2, 
                    'city' => NULL, 
                    'shipping_zone_id' =>  $request->region, 
                    'county' => NULL, 
                    'postcode' =>  $request->postcode, 
                ]);
                Session::put('guest_billing_address_id', $address->id);
                Session::flash('success', 'New address saved successfully!');
            }
        } else {
            // No existing address ID, create a new address
            $address = Address::create([
                    'first_name' => $request->first_name, 
                    'last_name' =>  $request->last_name, 
                    'mobile_number' =>  $request->mobile_number, 
                    'country_id' =>  $request->country, 
                    'address_line_1' =>  $request->address_line_1, 
                    'address_line_2' =>  $request->address_line_2, 
                    'city' => NULL, 
                    'shipping_zone_id' =>  $request->region, 
                    'county' => NULL, 
                    'postcode' =>  $request->postcode, 
                ]);
            Session::put('guest_billing_address_id', $address->id);
            Session::flash('success', 'Address saved successfully!');
        }

        // Redirect back to the checkout page, removing the edit_address parameter
        if($request->from_where == 'single'){
              return redirect()->route('web.checkoutDetails.single', ['product_id' => $request->product_id]);
        }
        return redirect()->route('web.checkoutDetails');
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