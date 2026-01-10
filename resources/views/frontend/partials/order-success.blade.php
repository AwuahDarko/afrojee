@extends('frontend.layouts.app')

@section('title')
    Afrojee -Order Success
@endsection

@section('content')
    <section class="bg-white rounded-lg shadow-xl p-8 max-w-sm w-full text-center relative mx-auto my-auto">
        <!-- Close Button - still present but might be less relevant on a full page, kept for consistency -->
        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Success Message -->
        <h2 class="text-green-600 text-lg font-semibold mb-4">{{ __('common.order_success.title') }}</h2>

        <!-- Checkmark Icon -->
        <div class="mx-auto w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mb-6 shadow-lg">
            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Thank You Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('common.order_success.thank_you') }}</h1>
        <p class="text-gray-600 mb-6">
            {{ __('common.order_success.delivery_message') }} <span class="font-semibold">{{ __('common.order_success.delivery_days') }}</span>.
            <br>
            {{ __('common.order_success.appreciation') }}
        </p>

        <!-- Done Button -->
        <button
            class="w-full bg-purple-700 hover:bg-purple-800 text-white font-medium py-3 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75">
            {{ __('common.order_success.done') }}
        </button>
    </section>
@endsection