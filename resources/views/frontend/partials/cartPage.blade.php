@extends('frontend.layouts.app')

@section('title')
    Afrojee - Cart
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Shopping Cart</h1>

    <div id="full-cart-items-list" class="bg-white shadow-md rounded-lg p-6">
        <p class="text-gray-500 text-center text-lg" id="full-empty-cart-message">Your cart is empty.</p>
        {{-- Cart items will be populated here by cartPage.js --}}
    </div>

    <div class="mt-8 bg-white shadow-md rounded-lg p-6 flex justify-between items-center">
        <span class="text-2xl font-semibold">Cart Total:</span>
        <span id="full-cart-total" class="text-3xl font-bold text-pink-800">$0.00</span>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('web.checkoutDetails') }}" class="px-8 py-4 bg-pink-800 text-white text-lg font-semibold rounded-md hover:bg-pink-900 transition duration-200">
            Proceed to Checkout
        </a>
    </div>
</div>
@endsection

@section('script')
{{-- cartPage.js will handle populating this page --}}
<script src="{{ asset('js/cartPage.js') }}"></script>
@endsection