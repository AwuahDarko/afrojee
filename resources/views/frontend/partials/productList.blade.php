@extends('frontend.layouts.app')

@section('title')
    Afrojee - Browse our products
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
        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .border-primary { border-color: var(--primary); }
        .text-accent { color: var(--accent); }
        .bg-accent { background-color: var(--accent); }

        /* ===================================
           PRODUCT CARD
           =================================== */
        .product-card {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        /* ===================================
           PRODUCT IMAGE
           =================================== */
        .product-image-wrapper {
            position: relative;
            height: 320px;
            overflow: hidden;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .image-overlay {
            opacity: 1;
        }

        /* ===================================
           BADGES
           =================================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            box-shadow: var(--shadow-sm);
        }

        .badge-new {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .badge-stock {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .badge-discount {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .badge-category {
            background: var(--primary-light);
            color: var(--primary-dark);
            border: 1px solid rgba(239, 56, 13, 0.2);
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

        .stock-low { background: #ef4444; }
        .stock-medium { background: #f59e0b; }
        .stock-high { background: #10b981; }

        .stock-low-dot { animation: pulse-red 2s infinite; }

        @keyframes pulse-red {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            50% { opacity: 0.8; box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        }

        /* ===================================
           PRODUCT INFO
           =================================== */
        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            background: white;
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
           GRID LAYOUT
           =================================== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
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
            to { transform: rotate(360deg); }
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
                    <div class="bg-gradient-to-r from-primary to-primary-dark h-1 w-full min-w-32 mt-4 ml-8 rounded-full"></div>
                </div>
                <p class="text-gray-600 text-lg md:text-xl max-w-4xl leading-relaxed">
                    Explore our collection and find the perfect products to elevate your beauty routine
                </p>
            </div>

            <!-- Search -->
            <form action="{{route('web.product.search')}}" method="GET">
                <div class="search-wrapper">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input name="q" type="text" placeholder="Search for products..." class="search-input" value="{{ $_GET['q'] ?? '' }}"/>
                    <button type="submit" class="search-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Filters -->
            <div class="filter-container">
                <a href="{{ route('web.products') }}" class="filter-btn {{ request()->routeIs('web.products') ? 'active' : '' }}">
                    All Products
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('web.products.filterByCategory', ['slug' => $category->slug]) }}"
                       class="filter-btn {{ request()->routeIs('web.products.filterByCategory') && request()->route('slug') == $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                @forelse ($products as $product)
                    <article class="product-card">
                        <!-- Image -->
                        <div class="product-image-wrapper">
                            <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                                <img src="{{ $product->getPrimaryImage()?->image_path ?? $product->image ?? asset('images/default-product.png') }}"
                                     alt="{{ $product->name }}"
                                     class="product-image"
                                     onerror="this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop'">
                            </a>
                            <div class="image-overlay"></div>

                            <!-- Badges -->
                            <div class="badges-container">
                                @if($product->created_at && $product->created_at->diffInDays(now()) <= 50)
                                    <span class="badge badge-new">✨ New</span>
                                @endif
                                @if(isset($product->quantity))
                                    <span class="badge badge-stock">🏷️ {{ $product->quantity }} left</span>
                                @endif
                                @if ($product->getPrice() != $product->getOriginalPrice())
                                    @php
                                        $discount = (($product->getOriginalPrice() - $product->getPrice()) / $product->getOriginalPrice()) * 100;
                                    @endphp
                                    <span class="badge badge-discount">-{{ number_format($discount, 0) }}%</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="actions-container">
                                <!-- Share -->
                                <div class="share-dropdown flex justify-end">
                                    <button class="action-btn share-toggle" title="Share Product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                        </svg>
                                    </button>
                                    <div class="share-menu">
                                        <div class="share-menu-title">Share this product</div>
                                        <a href="javascript:void(0)" onclick="shareProduct('facebook', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}')" class="share-option">
                                            <svg class="share-icon text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            <span>Facebook</span>
                                        </a>
                                        <a href="javascript:void(0)" onclick="shareProduct('twitter', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}')" class="share-option">
                                            <svg class="share-icon text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                            <span>Twitter</span>
                                        </a>
                                        <a href="javascript:void(0)" onclick="shareProduct('whatsapp', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}')" class="share-option">
                                            <svg class="share-icon text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                                            <span>WhatsApp</span>
                                        </a>
                                        <div class="share-divider"></div>
                                        <button onclick="copyProductLink('{{ route('web.products.details', $product->slug) }}')" class="share-option">
                                            <svg class="share-icon text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <span>Copy Link</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Stock Status -->
                                @if(isset($product->quantity))
                                    <div class="stock-indicator">
                                        @if($product->quantity <= 5)
                                            <span class="stock-dot stock-low stock-low-dot"></span>
                                            <span>Almost Out!</span>
                                        @elseif($product->quantity <= 20)
                                            <span class="stock-dot stock-medium"></span>
                                            <span>Low Stock</span>
                                        @else
                                            <span class="stock-dot stock-high"></span>
                                            <span>In Stock</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="product-info">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="product-title">
                                    <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                @if($product->category)
                                    <span class="badge badge-category">{{ $product->category->name }}</span>
                                @endif
                            </div>

                           {{-- @if(isset($product->description))
                                <p class="product-description">{!! Str::limit($product->description, 100) !!}</p>
                            @endif --}}

                            <!-- Price & Actions -->
                            <div class="price-section">
                                <div class="price-wrapper">
                                    @if ($product->getPrice() != $product->getOriginalPrice())
                                        <div class="price-original">
                                            {{ app_currency() }} {{ number_format($product->getOriginalPrice(), 2) }}
                                        </div>
                                    @endif
                                    <div class="price-current">
                                        {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                                    </div>
                                </div>

                                <div class="cart-actions">
                                    @if(!isset($product->quantity) || $product->quantity > 0)
                                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1, 'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0]) }}"
                                           class="btn btn-primary">
                                            Buy Now
                                        </a>

                                        <button class="btn btn-outline btn-icon cart-item-btn"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ number_format($product->getPrice(), 2) }}"
                                                data-product-image="{{ $product->getPrimaryImage()?->image_path ?? $product->image ?? asset('images/default-product.png') }}"
                                                title="Add to Cart">
                                            <span class="spinner hidden"></span>
                                            <svg class="w-5 h-5 cart-icon" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </button>

                                        <a href="{{ route('web.products.details', $product->slug) }}"
                                           class="btn btn-outline btn-icon"
                                           title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    @else
                                        <button class="btn btn-disabled btn-icon" disabled title="Out of Stock">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h2 class="empty-state-title">No Products Found</h2>
                        <p class="empty-state-text">
                            We couldn't find any products matching your filters or category.
                            Try adjusting your filters or check back later for new arrivals.
                        </p>
                        <a href="{{ route('web.products') }}" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to All Products
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <nav class="pagination">
                    <a href="{{ $products->previousPageUrl() }}"
                       class="pagination-btn {{ $products->onFirstPage() ? 'disabled' : '' }}">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
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
                        <a href="{{ $products->url($i) }}"
                           class="pagination-btn {{ $i === $current ? 'active' : '' }}">
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
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </nav>
            @endif
        </div>
    </section>

    <script>
        // Share Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.share-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
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
            document.addEventListener('click', function(e) {
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
            
            switch(platform) {
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
            navigator.clipboard.writeText(url).then(function() {
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
            }).catch(function(err) {
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
            button.addEventListener('click', function() {
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