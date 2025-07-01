<nav class="bg-cream border-b border-gold/20 py-4 px-4 md:px-8 lg:px-16">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Mobile menu button -->
        <div class="block lg:hidden">
            <button id="mobile-menu-button" class="text-gold focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Left navigation -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="/"
                class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('/') ? 'active-nav-link' : '' }}">
                Home
            </a>
            <div class="relative group">
                <button
                    class="text-gold font-medium hover:text-gold/80 transition flex items-center relative {{ request()->is('products*') ? 'active-nav-link' : '' }}">
                    Products
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 z-50">
                    <div class="py-2 px-4">
                        <a href="/products" class="block py-2 text-gray-700 hover:text-gold">All Products</a>
                        @foreach($categories as $category)
                            <a href="/products/{{ $category->slug }}" class="block py-2 text-gray-700 hover:text-gold">
                                {{ $category->name  }}
                            </a>
                        @endforeach
                        <!-- <a href="/products/skin" class="block py-2 text-gray-700 hover:text-gold">Skin Products</a>
                        <a href="/products/hair" class="block py-2 text-gray-700 hover:text-gold">Hair Products</a>
                        <a href="/products/others" class="block py-2 text-gray-700 hover:text-gold">Others</a> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo -->
        <div class="flex items-center">
            <a href="/" class="flex flex-col items-center">
                <h1 class="text-2xl md:text-3xl font-serif text-gold italic">Afro Jee</h1>
                <!-- <span class="text-xs text-gold/80">Lifestyle Beauty</span> -->
            </a>
        </div>

        <!-- Right navigation -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="/about"
                class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('about') ? 'active-nav-link' : '' }}">
                About Us
            </a>
            <a href="/faq"
                class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('faqs') ? 'active-nav-link' : '' }}">
                FAQs
            </a>
        </div>

        <!-- User account button -->
        <div class="flex items-center space-x-4">
            <button id="open-cart-sidebar"
                class="relative bg-white text-pink-800 w-10 h-10 rounded-full flex items-center justify-center border border-pink-800 hover:bg-pink-100 transition-colors duration-200">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z"
                        stroke="#99395C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M3 6H21" stroke="#99395C" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10"
                        stroke="#99395C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span id="cart-count"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
            </button>
            <button class="bg-rosegold hidden text-white w-10 h-10 rounded-full flex items-center justify-center">
                <span class="font-medium text-sm">RO</span>
            </button>
        </div>
    </div>

    <!-- Mobile menu, hidden by default -->
    <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4">
        <a href="/"
            class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('/') ? 'active-nav-link' : '' }}">
            Home
        </a>
        <div class="relative">
            <button id="mobile-products-button"
                class="w-full text-left py-2 text-gold hover:text-gold/80 flex items-center justify-between relative {{ request()->is('products*') ? 'active-nav-link' : '' }}">
                Products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="mobile-products-dropdown" class="hidden pl-4 pt-2">
                <a href="/products" class="block py-2 text-gold/80 hover:text-gold">All Products</a>
                @foreach($categories as $category)
                    <a href="/products/{{ $category->slug }}" class="block py-2 text-gold/80 hover:text-gold">
                        {{ $category->name  }}
                    </a>
                @endforeach
                <!-- <a href="/products/skin" class="block py-2 text-gold/80 hover:text-gold">Skin Products</a>
                <a href="/products/hair" class="block py-2 text-gold/80 hover:text-gold">Hair Products</a>
                <a href="/products/others" class="block py-2 text-gold/80 hover:text-gold">Others</a> -->
            </div>
        </div>
        <a href="/about"
            class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('about') ? 'active-nav-link' : '' }}">
            About Us
        </a>
        <a href="/faq"
            class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('faqs') ? 'active-nav-link' : '' }}">
            FAQs
        </a>
    </div>
</nav>

<style>
    .active-nav-link::after {
        /* content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 2px;
        background-color: currentColor; */
    }
</style>

<script>
    // This assumes you're using Laravel - adjust the condition if using another framework
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile menu toggle functionality would go here
        // You'll need to keep your existing JavaScript for mobile menu toggling
    });
</script>