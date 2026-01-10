@extends('frontend.layouts.app')

@section('title')
    Afrojee - {{ __('common.cart.title') }}
@endsection

@section('content')
    <section class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8"> {{-- Added padding for mobile --}}
        <h1 class="text-4xl font-semibold text-gray-800 mb-8 text-center md:text-left">{{ __('common.cart.title') }}</h1>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Left Column: Dynamic Cart Items Display --}}
            <div id="cart-items-container" class="md:col-span-2 bg-white rounded-xl p-4 shadow-sm">
                @php
                    $totalItemsInCart = 0;
                    $subtotalBill = 0;
                @endphp

                @if(isset($cartItems) && count($cartItems) > 0)
                    @foreach($cartItems as $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                            $totalItemsInCart += $item['quantity'];
                            $subtotalBill += $itemTotal;
                        @endphp
                        <div class="cart-item flex flex-col sm:flex-row items-center p-4 sm:p-8 border-b border-gray-300 last:border-b-0"
                            data-product-id="{{ $item['productId'] }}" data-price="{{ $item['price'] }}"
                            data-quantity="{{ $item['quantity'] }}">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-lg mb-4 sm:mb-0 sm:mr-4 object-cover" />
                            <div class="flex-grow w-full">
                                <h1 class="font-semibold text-lg sm:text-xl mb-2 sm:mb-0">
                                    {{ $item['name'] }}
                                </h1>
                                <div class="flex flex-col sm:flex-row sm:items-center text-gray-600 mt-2 sm:mt-0">
                                    <p class="text-pink-800 font-bold text-xl sm:text-2xl mr-4 sm:border-r-2 sm:pr-5 mb-2 sm:mb-0">
                                        <span class="hidden inline-block mb-1 -mr-1">
                                            <svg width="12" height="15" viewBox="0 0 11 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.72 16.915q-1.58 0-2.76-.58-1.16-.58-2.12-1.74l1.76-1.78q.62.82 1.4 1.32.8.48 1.86.48 1.08 0 1.7-.44t.62-1.24q0-.64-.36-1.04t-.96-.68a9.5 9.5 0 0 0-1.28-.5q-.7-.24-1.4-.54t-1.3-.74a3.5 3.5 0 0 1-.94-1.16q-.34-.72-.34-1.8 0-1.28.6-2.18.62-.9 1.68-1.38 1.08-.48 2.44-.48 1.32 0 2.44.54t1.86 1.4l-1.78 1.78q-.6-.68-1.24-1.04-.62-.36-1.34-.36-.98 0-1.52.38-.54.36-.54 1.12 0 .58.36.94t.94.62q.6.26 1.3.5.72.24 1.42.54.72.3 1.3.78.6.48.96 1.24.36.74.36 1.84 0 1.96-1.38 3.08-1.36 1.12-3.74 1.12m-.48-1.24h1.9v3.04h-1.9zm1.9-11.9h-1.9V.635h1.9z"
                                                    fill="#ef380d" />
                                            </svg>
                                        </span>
                                        {{ number_format($item['price'], 2) }} {{app_currency()}}
                                    </p>
                                    <span class="mr-2 font-bold mb-2 sm:mb-0">{{ __('common.cart.quantity') }}</span>
                                    <div class="flex items-center">
                                        <button
                                            class="quantity-minus px-3 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200"
                                            data-product-id="{{ $item['productId'] }}">
                                            -
                                        </button>
                                        <input type="text" value="{{ $item['quantity'] }}"
                                            class="quantity-input w-10 text-center mx-2 border-none focus:outline-none bg-transparent font-bold"
                                            readonly data-product-id="{{ $item['productId'] }}" />
                                        <button
                                            class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 mr-auto"
                                            data-product-id="{{ $item['productId'] }}">
                                            +
                                        </button>
                                    </div>
                                    <button
                                        class="delete-item px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 ml-auto mt-4 sm:mt-0"
                                        data-product-id="{{ $item['productId'] }}">
                                        <svg width="17" height="21" viewBox="0 0 17 21" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.702 5.43h14m-9 3v8m4-8v8m-4-15h4a1 1 0 0 1 1 1v3h-6v-3a1 1 0 0 1 1-1m-4 4h12v13a1 1 0 0 1-1 1h-10a1 1 0 0 1-1-1z"
                                                stroke="#C63636" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-8">{{ __('common.cart.empty') }}</p>
                @endif
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="md:col-span-1 bg-white rounded-2xl shadow-sm h-fit sticky top-8 overflow-hidden p-6"> {{-- Added p-6
                here --}}
                <div class="flex justify-between items-center mb-4">
                    <p class="text-lg text-gray-700">
                        {{ __('common.cart.subtotal') }} (<span id="cart-item-count">{{ $totalItemsInCart }}</span> {{ __('common.cart.items') }})
                    </p>
                    <p class="text-xl font-bold text-gray-900">
                        <span id="cart-subtotal">{{ number_format($subtotalBill, 2) }}</span> {{app_currency()}}
                    </p>
                </div>
                <button id="checkout-page-proceed-btn" {{-- Added ID for potential JS interaction if needed --}}
                    class="bg-pink-800 hover:bg-pink-900 text-white px-16 py-3 rounded-full font-medium w-full flex items-center justify-center gap-2 mb-6"
                    {{-- Adjusted classes for full width --}}>
                    {{ __('common.checkout.proceed_to_checkout') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="flex justify-center space-x-3">
                    <img src="/images/card.png?text=VISA" alt="Visa" class="h-full object-contain" />
                    
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Event delegation for quantity and delete buttons on the checkout page
            // (If you want these to directly update the cart on the server, you'd need AJAX requests)
            document.getElementById('cart-items-container').addEventListener('click', (event) => {
                const target = event.target;
                const itemElement = target.closest('.cart-item');
                if (!itemElement) return;

                const productId = itemElement.dataset.productId;
                let currentQuantityInput = itemElement.querySelector('.quantity-input');
                let currentQuantity = parseInt(currentQuantityInput.value);

                if (target.classList.contains('quantity-minus')) {
                    if (currentQuantity > 1) {
                        currentQuantityInput.value = currentQuantity - 1;
                        // For a live cart, you'd send an AJAX request here to update the quantity on the server.
                        // Example: updateCartItemOnServer(productId, currentQuantity - 1);
                    } else {
                        // If quantity becomes 0, remove the item
                        itemElement.remove();
                        // Example: removeCartItemFromServer(productId);
                    }
                    updateCheckoutTotals(); // Update client-side totals

                } else if (target.classList.contains('quantity-plus')) {
                    currentQuantityInput.value = currentQuantity + 1;
                    // Example: updateCartItemOnServer(productId, currentQuantity + 1);
                    updateCheckoutTotals(); // Update client-side totals

                } else if (target.classList.contains('delete-item') || target.closest('.delete-item')) {
                    itemElement.remove();
                    // Example: removeCartItemFromServer(productId);
                    updateCheckoutTotals(); // Update client-side totals
                }
            });

            // Function to recalculate and update displayed totals on the cart page
            function updateCheckoutTotals() {
                let totalItems = 0;
                let subtotal = 0;
                document.querySelectorAll('.cart-item').forEach(itemElement => {
                    const price = parseFloat(itemElement.dataset.price);
                    const quantity = parseInt(itemElement.querySelector('.quantity-input').value);
                    totalItems += quantity;
                    subtotal += price * quantity;
                });

                document.getElementById('cart-item-count').textContent = totalItems;
                document.getElementById('cart-subtotal').textContent = subtotal.toFixed(2);
            }

            // --- IMPORTANT: This is the updated part for the "Proceed to checkout" button ---
            document.getElementById('checkout-page-proceed-btn').addEventListener('click', () => {
                const cartItemsData = [];
                document.querySelectorAll('.cart-item').forEach(itemElement => {
                    // Collect all necessary data from the HTML
                    cartItemsData.push({
                        productId: itemElement.dataset.productId,
                        name: itemElement.querySelector('h1').textContent.trim(),
                        price: parseFloat(itemElement.dataset.price),
                        quantity: parseInt(itemElement.querySelector('.quantity-input').value),
                        image: itemElement.querySelector('img').src,
                        // Add any other properties you need, like slug, category, etc.
                    });
                });

                if (cartItemsData.length === 0) {
                    alert('{{ __('common.cart.empty_checkout_message') }}');
                    return;
                }

                // Send cart data to the Laravel backend via AJAX
                fetch('{{ route('web.checkout.processCart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token for security
                    },
                    body: JSON.stringify({ cart_data: cartItemsData })
                })
                .then(response => {
                    if (!response.ok) {
                        // Handle HTTP errors
                        return response.json().then(err => { throw err; });
                    }
                    return response.json(); // Assuming your controller returns a JSON response on success (e.g., redirect URL)
                })
                .then(data => {
                    // Redirect to the checkout page after successful processing
                    window.location.href = '{{ route('web.checkoutDetails') }}';
                })
                .catch(error => {
                    console.error('Error proceeding to checkout:', error);
                    alert('{{ __('common.cart.checkout_error') }}');
                });
            });
        });
    </script>
@endsection
