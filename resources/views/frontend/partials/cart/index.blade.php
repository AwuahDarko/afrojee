@extends('frontend.layouts.app')

@section('title')
    Afrojee - Your Cart
@endsection

@section('content')
    <section class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8"> {{-- Added padding for mobile --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Your Shopping Cart</h1>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Left Column: Dynamic Cart Items Display --}}
            <div id="full-cart-items-list" class="md:col-span-2 bg-white rounded-xl p-4 shadow-sm">
                <p class="text-gray-500 text-center text-lg py-8" id="full-empty-cart-message">Your cart is empty.</p>
                {{-- Cart items will be populated here by cartPage.js --}}
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="md:col-span-1 bg-white rounded-2xl shadow-sm h-fit sticky top-8 overflow-hidden p-6">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-lg text-gray-700">
                        Sub-total (<span id="cart-item-count">0</span> items)
                    </p>
                    <p class="text-xl font-bold text-gray-900">
                        {{app_currency()}} <span id="full-cart-total">0.00</span>
                    </p>
                </div>
                <a href="{{ route('web.checkoutDetails') }}" id="nav-link"
                    class="block bg-pink-800 hover:bg-pink-900 text-white px-10 py-3 rounded-full font-medium w-full text-center flex items-center justify-center gap-2 mb-6">
                    Proceed to checkout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                {{-- <div class="flex justify-center space-x-3">
                    <img src="/images/card.png?text=VISA" alt="Visa" class="h-full object-contain" />
            
                </div> --}}
            </div>
        </div>
    </section>
    <script src="{{ asset('js/cartPage.js') }}"></script>

@endsection