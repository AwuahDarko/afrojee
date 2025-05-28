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
            <a href="#" class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('/') ? 'active-nav-link' : '' }}">
                Home
            </a>
            <div class="relative group">
                <button class="text-gold font-medium hover:text-gold/80 transition flex items-center relative {{ request()->is('products*') ? 'active-nav-link' : '' }}">
                    Products
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div
                    class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 z-50">
                    <div class="py-2 px-4">
                        <a href="#" class="block py-2 text-gray-700 hover:text-gold">Category 1</a>
                        <a href="#" class="block py-2 text-gray-700 hover:text-gold">Category 2</a>
                        <a href="#" class="block py-2 text-gray-700 hover:text-gold">Category 3</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo -->
        <div class="flex items-center">
            <a href="#" class="flex flex-col items-center">
                <h1 class="text-2xl md:text-3xl font-serif text-gold italic">YaaSerwaa</h1>
                <span class="text-xs text-gold/80">Lifestyle Beauty</span>
            </a>
        </div>

        <!-- Right navigation -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="/about" class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('about') ? 'active-nav-link' : '' }}">
                About Us
            </a>
            <a href="/faq" class="text-gold font-medium hover:text-gold/80 transition relative {{ request()->is('faqs') ? 'active-nav-link' : '' }}">
                FAQs
            </a>
        </div>

        <!-- User account button -->
        <div>
            <button class="bg-rosegold text-white w-10 h-10 rounded-full flex items-center justify-center">
                <span class="font-medium text-sm">RO</span>
            </button>
        </div>
    </div>

    <!-- Mobile menu, hidden by default -->
    <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4">
        <a href="#" class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('/') ? 'active-nav-link' : '' }}">
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
                <a href="#" class="block py-2 text-gold/80 hover:text-gold">Category 1</a>
                <a href="#" class="block py-2 text-gold/80 hover:text-gold">Category 2</a>
                <a href="#" class="block py-2 text-gold/80 hover:text-gold">Category 3</a>
            </div>
        </div>
        <a href="/about" class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('about') ? 'active-nav-link' : '' }}">
            About Us
        </a>
        <a href="#" class="block py-2 text-gold hover:text-gold/80 relative {{ request()->is('faqs') ? 'active-nav-link' : '' }}">
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
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle functionality would go here
        // You'll need to keep your existing JavaScript for mobile menu toggling
    });
</script>
