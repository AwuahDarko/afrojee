@php
    $cartItems = collect(session('cart', []));
    $cartCount = $cartItems->sum(function ($item) {
        if (is_array($item)) {
            return (int) ($item['quantity'] ?? 0);
        }

        if (is_object($item) && isset($item->quantity)) {
            return (int) $item->quantity;
        }

        return 1;
    });
@endphp

<nav class="header-section sticky-header bg-gradient-to-r from-[#fffaf8] via-[#ffe8e3] to-[#fffaf8] shadow-md sticky top-0 z-50"
    x-data="{ mobileMenuOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <!-- Logo (left) -->
            <div class="logo flex items-center">
                <a href="{{ route('home') }}" class="text-inherit">
                    <img src="{{ asset('/images/afro_logo.jpeg') }}" alt="Afro Jee Logo" class="h-20 w-auto">
                </a>
            </div>

            <!-- Desktop Nav Links (center) -->
            <ul class="hidden lg:flex items-center space-x-8 text-[#ef380d] font-bold">
                <li>
                    <a href="{{ route('home') }}" class="hover:underline transition">{{ __('common.nav.home') }}</a>
                </li>

                <!-- Products Dropdown -->
                <li class="relative group">
                    <a href="{{ route('web.products') }}" class="hover:underline transition flex items-center">
                        {{ __('common.nav.products') }}
                        <svg class="ml-1 w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </a>

                    <!-- Categories Dropdown -->
                    @if(isset($categories) && count($categories) > 0)
                        <ul class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 mt-2 w-48 z-10">
                            @foreach($categories as $category)
                                <li>
                                    <a href="/products/{{ $category->slug }}"
                                        class="block px-4 py-2 text-[#ef380d] hover:underline">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>

                <li>
                    <a href="{{ route('web.about') }}"
                        class="hover:underline transition">{{ __('common.nav.about') }}</a>
                </li>
                <li>
                    <a href="/contact-us" class="hover:underline transition">{{ __('common.nav.contact') }}</a>
                </li>
            </ul>

            <!-- Icons (right) -->
            <div class="flex items-center space-x-4">
                <!-- Language Switcher -->
                <div class="relative">
                    <button
                        class="text-[#ef380d] hover:opacity-80 flex items-center space-x-1 px-2 py-1 rounded-md hover:bg-white/50 transition"
                        type="button" onclick="document.getElementById('language-dropdown').classList.toggle('hidden')">
                        <span class="text-sm font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="language-dropdown"
                        class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                        <a href="{{ route('language.switch', 'en') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'bg-gray-50 font-semibold' : '' }}">
                            🇬🇧 English
                        </a>
                        <a href="{{ route('language.switch', 'es') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'es' ? 'bg-gray-50 font-semibold' : '' }}">
                            🇪🇸 Español
                        </a>
                    </div>
                </div>

                <!-- Search Icon -->
                <button class="text-[#ef380d] hover:opacity-80" id="search-toggle" type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                        </path>
                    </svg>
                </button>

                <!-- User Account -->
                <a href="{{ route('web.profile.management') }}" class="hidden text-[#ef380d] hover:opacity-80">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                </a>

                <!-- Cart with Badge -->
                <a href="{{ route('web.cart') }}" class="relative text-[#ef380d] hover:opacity-80">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span id="cart-count"
                        class="absolute -top-2 -right-2 bg-[#ef380d] text-white text-xs rounded-full px-2 py-1 {{ $cartCount > 0 ? '' : 'hidden' }}">
                        {{ $cartCount > 0 ? $cartCount : '' }}
                    </span>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden text-[#ef380d]" @click="mobileMenuOpen = !mobileMenuOpen">
                    <!-- Hamburger Icon -->
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                    <!-- Close Icon -->
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div class="lg:hidden" x-show="mobileMenuOpen" id="mobile-nav" style="display: none;">
            <ul class="space-y-4 py-4 text-center text-[#ef380d] font-bold">
                <li><a href="{{ route('home') }}" class="block hover:underline">{{ __('common.nav.home') }}</a></li>
                <li><a href="{{ route('web.products') }}" class="block hover:underline">{{ __('common.nav.shop') }}</a>
                </li>

                <!-- Mobile Categories -->
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <li>
                            <a href="/products/{{ $category->slug }}" class="block py-2 text-[#ef380d] hover:underline">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                @endif

                <li><a href="{{ route('web.about') }}" class="block hover:underline">{{ __('common.nav.about') }}</a>
                </li>
                <li><a href="/contact-us" class="block hover:underline">{{ __('common.nav.contact') }}</a></li>

                <!-- Mobile Language Switcher -->
                <li class="pt-4 border-t border-white/20">
                    <div class="flex items-center justify-center space-x-4">
                    <a href="{{ route('language.switch', ['locale' => 'en', 'redirect' => url()->current()]) }}"
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'en' ? 'bg-gray-50 font-semibold' : '' }}">
    🇬🇧 English
</a>
<a href="{{ route('language.switch', ['locale' => 'es', 'redirect' => url()->current()]) }}"
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ app()->getLocale() == 'es' ? 'bg-gray-50 font-semibold' : '' }}">
    🇪🇸 Español
</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>