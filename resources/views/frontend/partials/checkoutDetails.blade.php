@extends('frontend.layouts.app')


@section('title')
    Afrojee - Checkout
@endsection

@section('content')
    <section class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Checkout</h1>

        {{-- Session messages --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing address</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="bg-pink-100-light rounded-xl p-6 shadow-sm mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <button id="toggleAddressBtn" class="text-pink-700 hover:text-pink-800 font-medium">
                            {{ $editingAddress ? 'Cancel' : 'Change address' }}
                        </button>
                    </div>

                    @if ($editingAddress)
                        <form id="addressForm" action="{{ route('web.checkout.saveAddress') }}" method="POST"
                            class="space-y-4">
                            @csrf {{-- CSRF protection --}}
                             <input type="hidden" name="from_where" value="multiple">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-gray-700 text-sm font-medium mb-1">First
                                        Name</label>
                                    <input type="text" id="first_name" name="first_name" required
                                        value="{{ old('first_name', $userAddress->first_name ?? '') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-gray-700 text-sm font-medium mb-1">Last
                                        Name</label>
                                    <input type="text" id="last_name" name="last_name" required
                                        value="{{ old('last_name', $userAddress->last_name ?? '') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                                </div>
                            </div>

                            <div>
                                <label for="mobile_number" class="block text-gray-700 text-sm font-medium mb-1">Mobile
                                    Number</label>
                                <input type="tel" id="mobile_number" name="mobile_number" required
                                    value="{{ old('mobile_number', $userAddress->mobile_number ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            </div>

                              <div>
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email
                                    </label>
                                <input type="email" id="email" name="email" required
                                    value="{{ old('email', $userAddress->email ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            </div>

                            <div>
                                <label for="country" class="block text-gray-700 text-sm font-medium mb-1">Country</label>
                                <select id="country" name="country" autocomplete="off"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                                    <option value="0">Select destination country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country', $userAddress->country_id ?? '0') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }} </option>
                                    @endforeach
                                    {{-- Add other countries as needed --}}
                                </select>
                            </div>

                            <div>
                                <div>
                                    <label for="city"
                                        class="block text-gray-700 text-sm font-medium mb-1">City/Region</label>
                                    <select name="region" id="region" autocomplete="off" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">

                                    </select>
                                </div>

                            </div>

                            <div>
                                <label for="address_line_1" class="block text-gray-700 text-sm font-medium mb-1">Address
                                    Line
                                    1</label>
                                <input type="text" id="address_line_1" name="address_line_1" required
                                    placeholder="Enter your address"
                                    value="{{ old('address_line_1', $userAddress->address_line_1 ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            </div>

                            <div>
                                <label for="address_line_2" class="block text-gray-700 text-sm font-medium mb-1">Address
                                    Line 2 (Optional)</label>
                                <input type="text" id="address_line_2" name="address_line_2"
                                    placeholder="Enter Street name (Optional)"
                                    value="{{ old('address_line_2', $userAddress->address_line_2 ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            </div>

                            <div>
                                <label for="postcode" class="block text-gray-700 text-sm font-medium mb-1">Postcode</label>
                                <input type="text" id="postcode" name="postcode" placeholder="Enter your postcode"
                                    required value="{{ old('postcode', $userAddress->postcode ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            </div>

                            <div class="flex space-x-4 pt-4">
                                <button type="submit" id="saveAddressBtn"
                                    class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-2 rounded-full font-medium">
                                    Save Address
                                </button>
                                <button type="button" id="cancelEditBtn"
                                    class="border border-pink-800 text-pink-800 hover:bg-pink-50 px-6 py-2 rounded-full font-medium">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-gray-700 leading-relaxed">
                            @if ($userAddress)
                                {{-- Check if an address object exists --}}
                                <p class="font-bold">{{ $userAddress->first_name }} {{ $userAddress->last_name }}</p>
                                <p>{{ $userAddress->address_line_1 }}</p>
                                @if ($userAddress->address_line_2)
                                    <p>{{ $userAddress->address_line_2 }}</p>
                                @endif
                                <p>{{ $userAddress->country->name }}</p>
                                <p>{{ $userAddress->zone->zone_name }} </p>
                                <p>{{ $userAddress->postcode }}</p>
                                <p>{{ $userAddress->mobile_number }}</p>
                            @else
                                <p>No billing address entered yet. Click "Change address" to add your details.</p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Card Details</h2>

                    <div class="mb-4">
                        <label for="cardNumber" class="block text-gray-700 text-sm font-medium mb-2">Card Number</label>
                        <div class="relative">
                            <input type="text" id="cardNumber" placeholder="Enter card number"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                            <svg class="w-6 h-6 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="expiryDate" class="block text-gray-700 text-sm font-medium mb-2">Expiry
                                Date</label>
                            <input type="text" id="expiryDate" placeholder="MM/YY"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                        </div>
                        <div>
                            <label for="cvv" class="block text-gray-700 text-sm font-medium mb-2">CVV</label>
                            <input type="text" id="cvv" placeholder="Enter CVV"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="nameOnCard" class="block text-gray-700 text-sm font-medium mb-2">Name on Card</label>
                        <input type="text" id="nameOnCard" placeholder="Enter the name on the card"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                    </div>

                    <button
                        class="bg-pink-200-light hover:bg-pink-300-light text-pink-800 font-semibold px-6 py-3 rounded-full w-full transition duration-300 ease-in-out">
                        Use this card
                    </button>
                </div> --}}
            </div>

            <div class="md:col-span-2 bg-white rounded-xl p-6 shadow-sm h-fit sticky top-8">

               

                <h2 class="text-xl font-semibold text-gray-800 mb-6 my-2">Your Bill</h2>

                <div id="checkout-summary">
                    <div id="checkout-cart-items" class="space-y-4">
                        {{-- Populated by JS --}}
                    </div>
                     <div class="border-t border-gray-200 pt-4 mt-4 flex justify-between hidden">
                        <p class="text-lg font-semibold text-gray-800">Subtotal</p>
                        <p id="checkout-subtotal" class="text-lg font-bold text-pink-800">₵0.00</p>
                    </div>
                    <div class="flex justify-between items-center mb-3 mt-3">
                        <p class="text-gray-700">Product sub-total</p>
                        <p class="font-bold text-gray-900" id="total-lbl"> {{app_currency()}} {{ number_format(0, 2) }}</p>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-gray-700">Delivery</p>
                        @if ($userAddress)
                            <p class="font-bold text-gray-900" id="del-lbl"> {{app_currency()}} {{ number_format(0, 2) }}</p>
                        @else
                            <p class="font-bold text-gray-900" id="del-lbl"> Select region to determine cost </p>
                        @endif
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-300 pt-4 mb-6">
                        <p class="text-xl font-bold text-gray-900">Total</p>
                        <p class="text-3xl font-bold text-gray-900" id="grand-lbl"> {{app_currency()}} {{ number_format(0, 2) }}
                        </p>
                    </div>
                </div>
               <form action="{{route('web.order.multiple.save')}}" method="POST">
                 @csrf
                <input type="hidden" name="zone_id" value="{{$userAddress?->zone->id}}" id="order-zone">
                <input type="hidden" name="cart" value="" id="order-cart">
                 <button @if (!$userAddress) disabled @endif type="submit" 
                    class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-3 rounded-full font-medium w-full flex items-center justify-center gap-2">
                    Proceed to checkout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
               </form>
            </div>
        </div>

    </section>

    {{-- The modal for adding/editing addresses (kept for reference, but main form is inline) --}}
    <div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Billing address</h3>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form>
                {{-- Form fields are intentionally left generic here as the primary editing is now inline --}}
                <div class="space-y-4">
                    <div><label class="block font-medium text-gray-700 mb-1">First Name</label><input type="text"
                            placeholder="Enter first name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div><label class="block font-medium text-gray-700 mb-1">Last Name</label><input type="text"
                            placeholder="Enter last name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div><label class="block font-medium text-gray-700 mb-1">Mobile Number</label><input type="tel"
                            placeholder="Enter mobile number" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div><label class="block font-medium text-gray-700 mb-1">Country</label><select
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option>United States of America</option>
                        </select></div>
                    <div><label class="block font-medium text-gray-700 mb-1">Address</label><input type="text"
                            placeholder="Enter your address" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div><input type="text" placeholder="Enter Street name (Optional)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block font-medium text-gray-700 mb-1">City</label><input type="text"
                                placeholder="Enter the city you're from"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                        <div><label class="block font-medium text-gray-700 mb-1">County</label><input type="text"
                                placeholder="Enter the county you're from"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"></div>
                    </div>
                    <div><label class="block font-medium text-gray-700 mb-1">Postcode</label><input type="text"
                            placeholder="Enter your postcode" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="mt-8 space-y-4">
                    <button type="button"
                        class="bg-pink-800 hover:bg-pink-900 text-white w-full py-3 rounded-full font-medium">
                        Use this address
                    </button>
                    <button type="button"
                        class="border border-pink-800 text-pink-800 hover:bg-pink-50 w-full py-3 rounded-full font-medium">
                        Save this address
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleAddressBtn');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const region = document.getElementById('region');
    const country = document.getElementById('country');
    const summary = document.getElementById('del-lbl');
    const grand = document.getElementById('grand-lbl');
    const totalLbl = document.getElementById('total-lbl');
    const orderZone = document.getElementById('order-zone');
    const orderCart = document.getElementById('order-cart');
    const cartItemsContainer = document.getElementById('checkout-cart-items');
    const subtotalElement = document.getElementById('checkout-subtotal');
    const global_zone_id = {{ $userAddress?->zone->id ?? 0 }};
    const regionPriceUrl = "{{ route('web.checkoutDetails.info.getprice') }}";
    const regionUrl = "{{ route('web.checkoutDetails.info.region') }}";

    // -------------------- Address Editing Toggle --------------------
    function toggleEditMode() {
        const currentUrl = new URL(window.location.href);
        if ({{ $editingAddress ? 'true' : 'false' }}) {
            currentUrl.searchParams.delete('edit_address');
        } else {
            currentUrl.searchParams.set('edit_address', 'true');
        }
        window.location.href = currentUrl.toString();
    }

    toggleBtn?.addEventListener('click', toggleEditMode);
    cancelBtn?.addEventListener('click', toggleEditMode);

    // -------------------- CART LOGIC --------------------
    let cartData = JSON.parse(localStorage.getItem('shoppingCart') || '[]');

    function saveAndRenderCart() {
        localStorage.setItem('shoppingCart', JSON.stringify(cartData));
        renderCart();
        getNewPrice(orderZone.value || global_zone_id);
    }

    function renderCart() {
        cartItemsContainer.innerHTML = '';
        let subtotal = 0;
        console.log(subtotalElement)
        if (cartData.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="text-gray-600 text-center py-6">
                    Your cart is empty.<br>
                    <a href="/" class="text-pink-700 hover:underline font-medium">Continue shopping</a>
                </div>`;
            subtotalElement.textContent = `${appCurrency} 0.00`;
            totalLbl.textContent = `${appCurrency} 0.00`;
            summary.textContent = `${appCurrency} 0.00`;
            grand.textContent = `${appCurrency} 0.00`;
            return;
        }

        cartData.forEach((item, index) => {
            const itemSubtotal = parseFloat(item.price) * item.quantity;
            subtotal += itemSubtotal;

            const cartItem = document.createElement('div');
            cartItem.className = "flex items-center justify-between bg-gray-50 rounded-lg p-4 shadow-sm transition-all";
            cartItem.innerHTML = `
                <div class="flex items-center gap-4">
                    <img src="${item.image}" alt="${item.name}" class="w-16 h-16 rounded-md object-cover border border-gray-200">
                    <div>
                        <p class="font-semibold text-gray-800">${item.name}</p>
                        ${item.sizeName ? `<p class="text-sm text-gray-500">Size: ${item.sizeName}</p>` : ''}
                        <p class="text-sm text-gray-500">${appCurrency} ${parseFloat(item.price).toFixed(2)}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center border border-gray-300 rounded-full overflow-hidden">
                        <button class="quantity-btn decrease px-3 py-1 text-gray-700 hover:bg-pink-100 font-bold" data-index="${index}">−</button>
                        <span class="px-3 font-medium">${item.quantity}</span>
                        <button class="quantity-btn increase px-3 py-1 text-gray-700 hover:bg-pink-100 font-bold" data-index="${index}">+</button>
                    </div>
                    <p class="font-bold text-pink-800 w-20 text-right">${appCurrency} ${itemSubtotal.toFixed(2)}</p>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });

        subtotalElement.textContent = `${appCurrency} ${subtotal.toFixed(2)}`;
        totalLbl.textContent = `${appCurrency} ${subtotal.toFixed(2)}`;
        if (orderCart) orderCart.value = JSON.stringify(cartData);
    }

    // Quantity handlers
    cartItemsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('quantity-btn')) {
            const index = parseInt(e.target.dataset.index);
            const item = cartData[index];

            if (e.target.classList.contains('increase')) {
                item.quantity += 1;
            } else if (e.target.classList.contains('decrease')) {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                } else if (confirm(`Remove ${item.name} from cart?`)) {
                    cartData.splice(index, 1);
                }
            }
            saveAndRenderCart();
        }
    });

    // -------------------- REGION & COUNTRY HANDLING --------------------
    region?.addEventListener('change', () => {
        const val = region.value;
        if (!val) return;
        orderZone.value = val;
        getNewPrice(val);
    });

    country?.addEventListener('change', () => {
        const val = country.value;
        if (val != '0') {
            fetch(`${regionUrl}?country_id=${val}`)
                .then(res => res.text())
                .then(data => region.innerHTML = data)
                .catch(console.error);
        }
    });

    // -------------------- PRICE RECALCULATION --------------------
    function getNewPrice(zone_id) {
        if (!zone_id && !global_zone_id) return;
        const z = zone_id || global_zone_id;
        const cart = JSON.stringify(cartData);

        fetch(`${regionPriceUrl}?cart=${encodeURIComponent(cart)}&zone_id=${z}`)
            .then(res => res.json())
            .then(data => {
                summary.textContent = data.total_shipping;
                grand.textContent = data.grand_total;
            })
            .catch(console.error);
    }

    // -------------------- Initialize --------------------
    renderCart();
    getNewPrice(global_zone_id);

    @if(!$userAddress)
        const currentUrl = new URL(window.location.href);
        if (!currentUrl.searchParams.has('edit_address')) {
            currentUrl.searchParams.set('edit_address', 'true');
            window.location.replace(currentUrl.toString());
        }
    @endif
});
</script>

@endsection
