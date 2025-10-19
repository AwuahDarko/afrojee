<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta name="local-file-base-url" content="{{ getLocalFileBaseURL() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))">
    <link rel='apple-touch-icon-precomposed' sizes='144x144' href="{{ asset('img/icons/apple-touch-icon.png') }}"
        type='image/x-icon' />
    <link rel='icon' href='{{ asset('img/icons/favicon.ico') }}' type='image/x-icon' />
    <link rel='shortcut icon' type='image/png' href='{{ asset('img/icons/favicon.png') }}' />

    @yield('meta')
    <title>@yield('title', 'AfroJee')</title>
    {{-- @if (!isset($product))
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ get_setting('meta_title') }}">
    <meta itemprop="description" content="{{ get_setting('meta_description') }}">
    <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
    <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ get_setting('meta_title') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}" />
    <meta property="og:description" content="{{ get_setting('meta_description') }}" />
    <meta property="og:site_name" content="{{ get_setting('site_name') }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    @endif
    <title>@yield('title', 'AfroJee')</title>
    <!-- <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon"> -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script type="module" src="{{ asset('js/app.js') }}"></script>
    <!-- Favicon -->
<script>
    const appCurrency = @json(app_currency());
</script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style type="text/tailwindcss">
        @theme {
            --color-clifford: #da373d;
            --font-sans: "Optima";
            --color-gold: #c8a655;
            --color-cream: #f8f6f1;
            --color-rosegold: #e0c3b6;
            --color-footergold: #f06243ff;
            --color-burgundy: #9d3f5b;
            --color-taupe: #806d48;
            --color-strip: #766455;
        }
    </style>


</head>

<body id="body">
    <!-- aiz-main-wrapper -->
    <div>

        <!-- Header -->
        @include('frontend.inc.nav')

        @yield('content')

        @include('frontend.inc.footer')
    </div>
    {{-- Cart Sidebar HTML --}}
    <div id="cart-sidebar"
        class="fixed right-0 top-0 w-80 bg-white h-full shadow-lg z-[100] transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto md:w-96">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Your Cart</h2>
            <button id="close-cart-sidebar" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div id="cart-items-list" class="p-4 space-y-4">
            {{-- Cart items will be rendered here by JavaScript --}}
        </div>
        <p class="text-gray-500 text-center" id="empty-cart-message">Your cart is empty.</p>
        <div id="cart-summary" class="p-4 border-t sticky bottom-0 bg-white shadow-inner">
            <div class="flex justify-between items-center mb-2">
                <span class="text-lg font-semibold">Total:</span>
                <span id="cart-total" class="text-lg font-bold text-pink-800">$0.00</span>
            </div>
            {{-- New: View Cart Button --}}
            <a href="{{ route('web.cart') }}" class="block w-full bg-gray-200 text-gray-800 text-center py-3 rounded-md hover:bg-gray-300 transition duration-200 mb-2">
                View Full Cart
            </a>
            {{-- Updated: Proceed to Checkout button now triggers JS --}}
            <button id="proceed-to-checkout-btn" class="block w-full bg-pink-800 text-white text-center py-3 rounded-md hover:bg-pink-900 transition duration-200">
                Proceed to Checkout
            </button>
            
        </div>
    </div>
    <div id="cart-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[90] hidden"></div>
    {{-- Hidden form for checkout submission --}}
    <form id="checkout-form" action="{{ route('web.checkoutDetails') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="cart_data" id="cart-data-input">
    </form>
    @yield('script')

    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>

</html>