@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-[#f5f0ea]">
        <div class="w-1/2 bg-cover bg-center relative" style="background-image: url('/images/signup-bg.jpg')">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute left-10 bottom-1/4 text-white z-10">
                <h1 class="text-4xl font-bold mb-4">{{ __('common.signin.title') }}</h1>
                <p class="text-2xl font-semibold">{{ __('common.signin.subtitle') }}</p>
            </div>
        </div>

        <div class="w-1/2 flex items-center justify-center bg-white">
            <div class="bg-white p-8 rounded-lg shadow-lg w-[400px]">
                <div class="space-y-3">
                    <!-- <a href="{{ route('login.google') }}" class="btn-social">
                        <img src="/icons/google.svg" class="inline w-4 mr-2" /> Continue with Google
                    </a>
                    <a href="{{ route('login.apple') }}" class="btn-social">
                        <img src="/icons/apple.svg" class="inline w-4 mr-2" /> Continue with Apple
                    </a>
                    <a href="{{ route('login.facebook') }}" class="btn-social">
                        <img src="/icons/facebook.svg" class="inline w-4 mr-2" /> Continue with Facebook
                    </a> -->
                </div>

                <div class="my-4 text-center text-sm text-gray-500">{{ __('common.signin.or') }}</div>

                <!-- action="{{ route('register') }}" -->
                <form method="POST" class="space-y-3">
                    @csrf
                    <input type="email" name="email" placeholder="{{ __('common.signin.email') }}"
                        class="w-full border p-2 rounded focus:outline-none focus:ring" required />
                    <input type="text" name="username" placeholder="{{ __('common.signin.username') }}"
                        class="w-full border p-2 rounded focus:outline-none focus:ring" />

                    <button type="submit" class="w-full bg-pink-200 text-white py-2 rounded hover:bg-pink-300">{{ __('common.signin.submit') }}</button>
                </form>

                <p class="text-xs text-gray-500 mt-3 text-center">
                    {{ __('common.signin.terms') }}
                    <a href="#" class="underline">{{ __('common.signin.terms_link') }}</a> {{ __('common.and') }}
                    <a href="#" class="underline">{{ __('common.signin.privacy_link') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection