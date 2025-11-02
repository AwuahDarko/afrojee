<nav class="header-section sticky-header bg-gradient-to-r from-[#fffaf8] via-[#ffe8e3] to-[#fffaf8] shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <!-- Logo (left) -->
            <div class="logo flex items-center">
                <a href="{{ route('home') }}" class="text-inherit">
                    <img src="{{ asset('/images/afro_logo.jpeg') }}" alt="Afro Jee Logo" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Nav Links (center) -->
            <ul class="hidden lg:flex items-center space-x-8 text-stone-700 font-medium">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-rose-500 transition">Home</a>
                </li>

                <!-- Products Dropdown -->
                <li class="relative group">
                    <a href="{{ route('web.products') }}" class="hover:text-rose-500 transition flex items-center">
                        Products
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </a>

                    <!-- Categories Dropdown -->
                    @if(isset($categories) && count($categories) > 0)
                        <ul class="absolute hidden group-hover:block bg-white shadow-lg rounded-md py-2 mt-2 w-48 z-10">
                            @foreach($categories as $category)
                                <li>
                                    <a href="/products/{{ $category->slug }}" class="block py-2 text-gray-700 hover:text-[#ef380d]">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>

                <li>
                    <a href="{{ route('web.about') }}" class="hover:text-rose-500 transition">About</a>
                </li>
                <li>
                    <a href="/contact-us" class="hover:text-rose-500 transition">Contact</a>
                </li>
            </ul>

            <!-- Icons (right) -->
            <div class="flex items-center space-x-6">
                <!-- Search Icon -->
                <button class="text-stone-700 hover:text-rose-500" id="search-toggle" type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                        </path>
                    </svg>
                </button>

                <!-- User Account -->
                <a href="{{ route('web.profile.management') }}" class="hidden text-stone-700 hover:text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                </a>

                <!-- Cart with Badge -->
                <a href="{{ route('web.cart') }}" class="relative text-stone-700 hover:text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    @if (session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-xs rounded-full px-2 py-1">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden text-stone-700" id="mobile-menu-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div class="lg:hidden hidden" id="mobile-nav">
            <ul class="space-y-4 py-4 text-center text-stone-700 font-medium">
                <li><a href="{{ route('web.products') }}" class="block hover:text-rose-500">Shop</a></li>

                <!-- Mobile Categories -->
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <li>
                            <a href="/products/{{ $category->slug }}" class="block py-2 text-gray-700 hover:text-[#ef380d]">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                @endif

                <li><a href="{{ route('web.about') }}" class="block hover:text-rose-500">About</a></li>
                <li><a href="/contact-us" class="block hover:text-rose-500">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>