@extends('frontend.layouts.app')

@section('title')
    Afrojee - Checkout
@endsection

@section('content')
    <section class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Afrojee Checkout</h1>

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
        <div class="grid md:grid-cols-3 gap-8">
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
                            <input type="hidden" name="from_where" value="single">
                            <input type="hidden" name="quantity" value="1" id="qty-lbl">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
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

        <div class="md:col-span-1 bg-gradient-to-br from-white to-gray-50 rounded-2xl p-5 sm:p-7 shadow-lg border border-gray-100 h-fit sticky top-4 sm:top-8 mx-auto w-full max-w-md md:max-w-none">
            
            <!-- Product Item Card -->
            <div class="cart-item bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100 mb-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                    <!-- Product Image -->
                    <div class="relative group">
                        <img src="{{ $product->getPrimaryImage()?->image_path ?? $product->image ?? asset('images/default-product.png') }}" alt="{{ $product->name }}"
                            class="w-28 h-28 rounded-xl object-cover shadow-md ring-2 ring-gray-100 group-hover:ring-pink-200 transition-all duration-300" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Product Info & Quantity -->
                    <div class="flex-1 w-full text-center sm:text-left">
                        <h3 class="font-bold text-lg sm:text-xl text-gray-900 mb-3">
                            {{ $product->name }}
                        </h3>
                        
                        <!-- Quantity Controls -->
                        <div class="inline-flex items-center bg-gray-50 rounded-full px-2 py-1.5 gap-1 shadow-inner">
                            <button
                                class="quantity-minus w-8 h-8 flex items-center justify-center bg-white border-2 border-gray-200 rounded-full hover:bg-pink-50 hover:border-pink-300 active:scale-95 transition-all duration-200 text-gray-700 font-semibold"
                                data-product-id="{{ $product->id }}" id="decrease-btn">
                                −
                            </button>
                            <input type="text" value="{{ $quantity }}"
                                class="quantity-input w-12 text-center border-none focus:outline-none bg-transparent font-bold text-lg text-gray-900"
                                readonly data-product-id="{{ $product->id }}" id="p-qty" />
                            <button
                                class="quantity-plus w-8 h-8 flex items-center justify-center bg-white border-2 border-gray-200 rounded-full hover:bg-pink-50 hover:border-pink-300 active:scale-95 transition-all duration-200 text-gray-700 font-semibold"
                                data-product-id="{{ $product->id }}" id="increase-btn">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bill Summary -->
            <div class="space-y-4 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="h-1 w-8 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full"></div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Order Summary</h2>
                </div>

                <div id="checkout-summary" class="space-y-3">
                    <!-- Subtotal -->
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm sm:text-base font-medium">Subtotal</span>
                        <span class="font-bold text-gray-900 text-base sm:text-lg">
                            {{app_currency()}} {{ number_format(($selectedSize ? $selectedSize->price : $product->getPrice()) * $quantity, 2) }}
                        </span>
                    </div>
                    
                    <!-- Delivery -->
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm sm:text-base font-medium">Delivery Fee</span>
                        @if ($userAddress)
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">FREE</span>
                                <span class="font-bold text-gray-900 text-base sm:text-lg">{{app_currency()}} 0.00</span>
                            </div>
                        @else
                            <span class="text-xs sm:text-sm text-amber-600 bg-amber-50 px-3 py-1.5 rounded-full font-semibold">
                                Select address
                            </span>
                        @endif
                    </div>
                    
                    <!-- Total -->
                    <div class="flex justify-between items-center pt-4 pb-2">
                        <span class="text-xl sm:text-2xl font-bold text-gray-900">Total</span>
                        <span class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-600 to-pink-700 bg-clip-text text-transparent">
                            {{app_currency()}} {{ number_format(($selectedSize ? $selectedSize->price : $product->getPrice()) * $quantity, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Checkout Button -->
            <form action="{{route('web.order.save')}}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="quantity" value="1" id="order-qty">
                <input type="hidden" name="zone_id" value="{{$userAddress?->zone->id}}" id="order-zone">
                <input type="hidden" name="size_id" value="{{ $size_id }}">
                
                <button @if (!$userAddress) disabled @endif type="submit"
                    class="group relative w-full bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 disabled:from-gray-300 disabled:to-gray-400 text-white px-6 py-4 rounded-xl font-bold text-base sm:text-lg shadow-lg hover:shadow-xl disabled:shadow-none transition-all duration-300 flex items-center justify-center gap-3 overflow-hidden active:scale-98">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <span class="relative z-10">Proceed to Checkout</span>
                    <svg class="relative z-10 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
                
                @if (!$userAddress)
                    <p class="text-center text-xs sm:text-sm text-gray-500 mt-3">
                        Please add a delivery address to continue
                    </p>
                @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleAddressBtn');
            const cancelBtn = document.getElementById('cancelEditBtn');

            // Toggle between edit and view modes by redirecting with a query parameter
            function toggleEditMode() {
                const currentUrl = new URL(window.location.href);
                if ({{ $editingAddress ? 'true' : 'false' }}) {
                    currentUrl.searchParams.delete('edit_address');
                } else {
                    currentUrl.searchParams.set('edit_address', 'true');
                }
                window.location.href = currentUrl.toString();
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleEditMode);
            }
            if (cancelBtn) {
                cancelBtn.addEventListener('click', toggleEditMode);
            }
            // The saveAddressBtn now performs a standard form submission,
            // handled by the route defined in the form's action attribute.

            const region = document.getElementById('region')
            const country = document.getElementById('country')
            const quantity = document.getElementById('p-qty')
            const qtylbl = document.getElementById('qty-lbl')
            const orderQty = document.getElementById('order-qty')
            const orderZone = document.getElementById('order-zone')
            const summary = document.getElementById('checkout-summary')
            const maxQty = {{ $product->quantity }}
            const id = {{ $product->id }}
            const global_zone_id = {{ $userAddress->zone->id ?? 0 }};
            const sizeId = {{ $size_id ?? 0 }};  // NEW: Get size_id from view variable
        
            getNewPrice(1, id, global_zone_id, sizeId)  // UPDATED: Pass sizeId

            region?.addEventListener('change', (evt) => {
                const val = region.value

                if (!val) return

                let qty = parseInt(quantity.value)
                orderZone.value = region.value


                getNewPrice(qty, id, region.value, sizeId)  // UPDATED: Pass sizeId
            })

            country?.addEventListener('change', (evt) => {
                const val = country.value
                if (val != '0') {

                    const url = "{{ route('web.checkoutDetails.info.region') }}"

                    fetch(`${url}?country_id=${val}`, )
                        .then(res => res.text())
                        .then(data => {
                            region.innerHTML = data
                        }).catch(error => console.log(error))
                }
            })

            document.getElementById('decrease-btn').addEventListener('click', (evt) => {
                let qty = parseInt(quantity.value)
                if (qty === 1) return

                quantity.value = --qty
                orderQty.value = quantity.value
                if(qtylbl){
                    qtylbl.value = quantity.value

                }
                
                getNewPrice(qty, id, region?.value ?? 0, sizeId)  // UPDATED: Pass sizeId
            })

            document.getElementById('increase-btn').addEventListener('click', (evt) => {
                let qty = parseInt(quantity.value)
                if (qty === maxQty) return

                quantity.value = ++qty
                orderQty.value = quantity.value
                 if(qtylbl){
                     qtylbl.value = quantity.value
                 }
                
                getNewPrice(qty, id, region?.value ?? 0, sizeId)  // UPDATED: Pass sizeId
            })

            function getNewPrice(qty, id, zone_id, size_id) {  // UPDATED: Accept size_id param
                if (!zone_id && !global_zone_id) return

                const z = zone_id || global_zone_id

                const url = "{{ route('web.checkoutDetails.info.price') }}"

                fetch(`${url}?qty=${qty}&id=${id}&zone_id=${z}&size_id=${size_id}`)  // UPDATED: Include size_id in query
                    .then(res => res.text())
                    .then(data => {
                        summary.innerHTML = data
                    }).catch(error => console.log(error))
            }



        });
    </script>
@endsection