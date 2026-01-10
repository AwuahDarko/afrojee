@extends('frontend.layouts.app')

@section('title')
    Afrojee - {{ __('common.productlist.title') }}
@endsection

@section('content')
    <style>
        :root {
            --primary: #ef380d;
            --primary-dark: #d6320c;
            --primary-light: rgba(239, 56, 13, 0.1);
            --accent: #F3BF45;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-light: #e5e7eb;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
            --radius-sm: 0.75rem;
            --radius-md: 1rem;
            --radius-lg: 1.5rem;
        }

        /* ===================================
               GLOBAL UTILITIES
               =================================== */
        .text-primary {
            color: var(--primary);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .border-primary {
            border-color: var(--primary);
        }

        .text-accent {
            color: var(--accent);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        /* ===================================
               PRODUCT CARD
               =================================== */
        .product-card {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: linear-gradient(145deg, #fffaf8, #ffe8e3);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
            background: linear-gradient(145deg, #ffe8e3, #ffd4c9);
        }




        /* ===================================
               BADGES CONTAINER
               =================================== */
        .badges-container {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 20;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        /* ===================================
               ACTION BUTTONS CONTAINER
               =================================== */
        .actions-container {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 20;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            color: var(--text-dark);
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
            border-color: var(--primary);
        }

        /* ===================================
               STOCK INDICATOR
               =================================== */
        .stock-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .stock-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
        }

        .stock-low {
            background: #ef4444;
        }

        .stock-medium {
            background: #f59e0b;
        }

        .stock-high {
            background: #10b981;
        }

        .stock-low-dot {
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            50% {
                opacity: 0.8;
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
            }
        }

        /* ===================================
               PRODUCT INFO
               =================================== */
        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            background: transparent;
        }

        .product-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            transition: color 0.2s ease;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card:hover .product-title {
            color: var(--primary);
        }

        .product-description {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ===================================
               PRICE SECTION
               =================================== */
        .price-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            margin-top: auto;
            border-top: 1px solid var(--border-light);
        }

        .price-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .price-current {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .price-original {
            font-size: 0.875rem;
            color: var(--text-light);
            text-decoration: line-through;
        }

        /* ===================================
               ACTION BUTTONS (BOTTOM)
               =================================== */
        .cart-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-icon {
            width: 2.75rem;
            height: 2.75rem;
            padding: 0;
        }

        .btn-disabled {
            background: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* ===================================
               SHARE DROPDOWN
               =================================== */
        .share-dropdown {
            position: relative;
        }

        .share-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            min-width: 200px;
            background: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.2s ease;
            z-index: 50;
        }

        .share-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .share-menu-title {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-light);
        }

        .share-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: background 0.15s ease;
            cursor: pointer;
        }

        .share-option:hover {
            background: var(--primary-light);
        }

        .share-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        .share-divider {
            height: 1px;
            background: var(--border-light);
            margin: 0.25rem 0;
        }

        /* ===================================
               FILTER SECTION
               =================================== */
        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            background: white;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ===================================
               SEARCH CONTAINER
               =================================== */
        .search-wrapper {
            display: flex;
            align-items: center;
            max-width: 600px;
            background: white;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 0.875rem 1.25rem;
            margin-bottom: 2rem;
            transition: all 0.2s ease;
        }

        .search-wrapper:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .search-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--text-light);
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.9375rem;
            color: var(--text-dark);
        }

        .search-input::placeholder {
            color: var(--text-light);
        }

        .search-btn {
            padding: 0.5rem 0.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-btn:hover {
            background: var(--primary-dark);
        }



        /* ===================================
               PAGINATION
               =================================== */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1rem;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            background: white;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .pagination-btn:hover:not(.disabled) {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .pagination-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-dots {
            padding: 0.625rem 0.5rem;
            color: var(--text-light);
        }

        /* ===================================
               EMPTY STATE
               =================================== */
        .empty-state {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            text-align: center;
            background: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
        }

        .empty-state-icon {
            width: 5rem;
            height: 5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .empty-state-text {
            font-size: 1rem;
            color: var(--text-light);
            max-width: 500px;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* ===================================
               LOADING SPINNER
               =================================== */
        .spinner {
            border: 2px solid var(--primary-light);
            border-top-color: var(--primary);
            border-radius: 50%;
            width: 1rem;
            height: 1rem;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===================================
               RESPONSIVE DESIGN
               =================================== */
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .product-image-wrapper {
                height: 280px;
            }

            .filter-container {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 0.5rem;
            }

            .filter-btn {
                flex-shrink: 0;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1025px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1440px) {
            .products-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>

<section class="bg-gradient-to-br from-white to-orange-50/20 py-16 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-primary">
                    View <br><span class="font-bold text-primary">Our Products</span>
                </h2>
                <div class="bg-gradient-to-r from-primary to-primary-dark h-1 w-full min-w-32 mt-4 ml-8 rounded-full">
                </div>
            </div>
            <p class="text-gray-600 text-lg md:text-xl max-w-4xl leading-relaxed">
                Explore our collection and find the perfect products to elevate your beauty routine
            </p>
        </div>

        <!-- Search -->
        <form action="{{route('web.product.search')}}" method="GET">
            <div class="search-wrapper">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input name="q" type="text" placeholder="Search for products..." class="search-input"
                    value="{{ $_GET['q'] ?? '' }}" />
                <button type="submit" class="search-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Filters -->
        <div class="filter-container">
            <a href="{{ route('web.products') }}"
                class="filter-btn {{ request()->routeIs('web.products') ? 'active' : '' }}">
                {{ __('common.productlist.all_products') }}
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('web.products.filterByCategory', ['slug' => $category->slug]) }}"
                    class="filter-btn {{ request()->routeIs('web.products.filterByCategory') && request()->route('slug') == $category->slug ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="gsp-search-recommend-collection-item group">
                        <div class="card overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 gsp-product-card">
                            <!-- Image Section -->
                            <figure class="gsp-product-card-image relative overflow-hidden mb-0"
                                style="--aspect-ratio: 1/1;">
                                <!-- Discount Badge -->
                                @if($product->getPrice() != $product->getOriginalPrice())
                                    @php
                                        $discountAmount = $product->getOriginalPrice() - $product->getPrice();
                                        $discountPercentage = $product->getOriginalPrice() > 0 ? ($discountAmount / $product->getOriginalPrice()) * 100 : 0;
                                    @endphp
                                    <span class="absolute top-3 left-3 z-10 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                        -{{ number_format($discountPercentage, 0) }}%
                                    </span>
                                @endif
                                <a href="{{ route('web.products.details', $product->slug) }}"
                                    class="gsp-product-featured block text-inherit img-hover-zoom-in {{ $product->images->count() > 1 ? 'has_second_image' : '' }}"
                                    title="{{ $product->name }}">
                                    <div class="gsp-image gsp-product-thumb-primary">
                                        <img src="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png') }}"
                                            alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover"
                                            width="540" height="720" />
                                    </div>
                                    @if ($product->images->count() > 1)
                                        <div class="gsp-image gsp-product-thumb-secondary absolute top-0 left-0 opacity-0">
                                            <img src="{{ asset($product->images[1]->image_path) }}"
                                                alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover"
                                                width="540" height="720" />
                                        </div>
                                    @endif
                                </a>

                                <!-- Quick Action Buttons - Shown on Hover -->
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <!-- Add to Cart Button -->
                                    <button type="button"
                                        class="cart-item-btn bg-white hover:bg-gray-900 text-gray-900 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->getPrice() }}"
                                        data-product-image="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png') }}"
                                        data-size-id="0"
                                        title="Add to Cart">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </button>

                                    <!-- Quick View Button -->
                                    <a href="{{ route('web.products.details', $product->slug) }}"
                                        class="bg-white hover:bg-gray-900 text-gray-900 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                                        title="Quick View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <!-- Wishlist Button -->
                                    <button type="button"
                                        class="bg-white hidden hover:bg-red-500 text-gray-900 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
                                        title="Add to Wishlist">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </figure>

                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <!-- Price -->
                                <div class="gsp-product-price gsp-product-card-price flex items-center text-sm mb-2 {{ $product->getPrice() != $product->getOriginalPrice() ? 'gsp-price-on-sale' : '' }}">
                                    @if ($product->getPrice() != $product->getOriginalPrice())
                                        <div class="gsp-product__price-sale">
                                            <span class="gsp-price-item-regular line-through text-stone-500 mr-2">
                                                {{ number_format($product->getOriginalPrice(), 2) }} {{ app_currency() }}
                                            </span>
                                            <span class="gsp-price-item-sale font-semibold text-rose-500">
                                                {{ number_format($product->getPrice(), 2) }} {{ app_currency() }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="gsp-product__price-regular">
                                            <span class="gsp-price-item-regular font-semibold text-stone-700">
                                                {{ number_format($product->getPrice(), 2) }} {{ app_currency() }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Name -->
                                <h3 class="gsp-product-card-title card-title mb-3 text-base font-medium relative">
                                    <a href="{{ route('web.products.details', $product->slug) }}"
                                        class="text-decoration-none text-stone-700 hover:text-rose-500 line-clamp-2">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <!-- Action Buttons Row (Always Visible on Mobile) -->
                                <div class="flex gap-2 mt-4 sm:hidden">
                                    <!-- Add to Cart -->
                                    <button type="button"
                                        class="cart-item-btn flex-1 bg-gray-900 hover:bg-gray-800 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->getPrice() }}"
                                        data-product-image="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png') }}"
                                        data-size-id="0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Cart
                                    </button>

                                    <!-- Buy Now -->
                                    <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1, 'size_id' => 0]) }}"
                                        class="flex-1 bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-50 py-2 px-3 rounded-lg text-sm font-medium transition-colors text-center">
                                        Buy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h2 class="empty-state-title">{{ __('common.productlist.no_products_found') }}</h2>
                        <p class="empty-state-text">
                            {{ __('common.productlist.no_products_message') }}
                        </p>
                        <a href="{{ route('web.products') }}" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to All Products
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <nav class="pagination">
                <a href="{{ $products->previousPageUrl() }}"
                    class="pagination-btn {{ $products->onFirstPage() ? 'disabled' : '' }}">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>

                @php
                    $current = $products->currentPage();
                    $last = $products->lastPage();
                @endphp

                @if ($current > 3)
                    <a href="{{ $products->url(1) }}" class="pagination-btn">1</a>
                    @if ($current > 4)
                        <span class="pagination-dots">...</span>
                    @endif
                @endif

                @for ($i = max(1, $current - 2); $i <= min($last, $current + 2); $i++)
                    <a href="{{ $products->url($i) }}" class="pagination-btn {{ $i === $current ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($current < $last - 2)
                    @if ($current < $last - 3)
                        <span class="pagination-dots">...</span>
                    @endif
                    <a href="{{ $products->url($last) }}" class="pagination-btn">{{ $last }}</a>
                @endif

                <a href="{{ $products->nextPageUrl() }}"
                    class="pagination-btn {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
                    Next
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        @endif
    </div>
</section>

<style>
/* Product Card Hover Effects */
.gsp-product-card {
    transition: all 0.3s ease;
}

.gsp-product-card:hover {
    transform: translateY(-4px);
}

/* Image Hover Effects */
.img-hover-zoom-in img {
    transition: transform 0.5s ease;
}

.img-hover-zoom-in:hover img {
    transform: scale(1.08);
}

.has_second_image:hover .gsp-product-thumb-primary {
    opacity: 0;
}

.has_second_image:hover .gsp-product-thumb-secondary {
    opacity: 1;
}

.gsp-product-thumb-secondary {
    transition: opacity 0.5s ease;
}

/* Line clamp for product names */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

    <script>
        // Share Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.share-toggle').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const menu = this.nextElementSibling;
                    const isActive = menu.classList.contains('active');

                    // Close all menus
                    document.querySelectorAll('.share-menu').forEach(m => {
                        m.classList.remove('active');
                    });

                    // Toggle current menu
                    if (!isActive) {
                        menu.classList.add('active');
                    }
                });
            });

            // Close on outside click
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.share-dropdown')) {
                    document.querySelectorAll('.share-menu').forEach(menu => {
                        menu.classList.remove('active');
                    });
                }
            });
        });

        // Share Functions
        function shareProduct(platform, url, title, description = '') {
            const encodedUrl = encodeURIComponent(url);
            const encodedTitle = encodeURIComponent(title);
            const encodedDesc = encodeURIComponent(description);

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedTitle}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${encodedTitle} ${encodedUrl}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }

            // Close menu
            document.querySelectorAll('.share-menu').forEach(menu => {
                menu.classList.remove('active');
            });
        }

        function copyProductLink(url) {
            navigator.clipboard.writeText(url).then(function () {
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;

                button.innerHTML = `
                            <svg class="share-icon text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span style="color: #10b981; font-weight: 600;">Copied!</span>
                        `;

                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    document.querySelectorAll('.share-menu').forEach(menu => {
                        menu.classList.remove('active');
                    });
                }, 2000);
            }).catch(function (err) {
                // Fallback
                const textArea = document.createElement('textarea');
                textArea.value = url;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);

                alert('Link copied to clipboard!');

                document.querySelectorAll('.share-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            });
        }

        // Cart Button Loading State
        document.querySelectorAll('.cart-item-btn').forEach(button => {
            button.addEventListener('click', function () {
                const spinner = this.querySelector('.spinner');
                const icon = this.querySelector('.cart-icon');

                if (spinner && icon) {
                    icon.classList.add('hidden');
                    spinner.classList.remove('hidden');

                    // Reset after 2 seconds (adjust based on your cart logic)
                    setTimeout(() => {
                        spinner.classList.add('hidden');
                        icon.classList.remove('hidden');
                    }, 2000);
                }
            });
        });
    </script>
@endsection