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
        }

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

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border: 1px solid rgba(239, 56, 13, 0.1);
        }

        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 25px 50px -12px rgba(239, 56, 13, 0.15),
                0 0 0 1px rgba(239, 56, 13, 0.1);
            border-color: rgba(239, 56, 13, 0.2);
        }

        .product-image {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #f5f5f5, #e5e5e5);
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .cart-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(10px);
            opacity: 0;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(239, 56, 13, 0.2);
        }

        .product-card:hover .cart-button {
            transform: translateY(0);
            opacity: 1;
        }

        .quantity-badge {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(239, 56, 13, 0.3);
            animation: pulse 2s infinite;
        }

        .new-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            animation: shimmer 2s ease-in-out infinite alternate;
        }

        .discount-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .category-badge {
            background: linear-gradient(135deg, var(--primary-light), rgba(239, 56, 13, 0.15));
            color: var(--primary-dark);
            border: 1px solid rgba(239, 56, 13, 0.2);
        }

        .filter-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 56, 13, 0.15);
            background: var(--primary);
            color: white;
        }

        .filter-btn.active-filter {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 56, 13, 0.2);
        }

        .search-container {
            transition: all 0.3s ease;
            border: 2px solid rgba(239, 56, 13, 0.2);
        }

        .search-container:focus-within {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(239, 56, 13, 0.15);
            border-color: var(--primary);
        }

        .pagination-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }

        .pagination-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 56, 13, 0.15);
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .pagination-button.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 56, 13, 0.3);
        }

        .share-dropdown .share-options {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .share-dropdown .share-options.opacity-100 {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .share-dropdown .share-options.opacity-0 {
            opacity: 0;
            visibility: hidden;
            transform: scale(0.95);
        }

        .glass-effect {
            backdrop-filter: blur(16px) saturate(180%);
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(239, 56, 13, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 6px 16px rgba(239, 56, 13, 0.4);
            }
        }

        @keyframes shimmer {
            0% {
                opacity: 0.8;
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            }
            100% {
                opacity: 1;
                box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-8px) rotate(2deg);
            }
        }

        .floating-accent {
            animation: float 6s ease-in-out infinite;
        }

        .hover-accent {
            opacity: 0;
            transform: scale(0.8) rotate(-5deg);
            transition: all 0.4s ease;
        }

        .product-card:hover .hover-accent {
            opacity: 0.6;
            transform: scale(1) rotate(0deg);
        }

        .price-tag {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(239, 56, 13, 0.3);
            position: relative;
            overflow: hidden;
        }

        .price-tag::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .product-card:hover .price-tag::after {
            left: 100%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }

        .loading-spinner {
            border: 3px solid rgba(239, 56, 13, 0.2);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stock-indicator {
            transition: all 0.3s ease;
        }

        .product-card:hover .stock-indicator {
            transform: scale(1.05);
        }

        .image-overlay {
            background: linear-gradient(to bottom, transparent 0%, rgba(239, 56, 13, 0.03) 100%);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <section class="bg-gradient-to-br from-white to-orange-50/30 py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
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
            <!-- <div class="mb-12">
                <div class="flex items-center mb-6">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe">
                        View <br><span class="font-bold">Our Products</span>
                    </h2>
                    <div class="bg-taupe h-1 w-full min-w-32 mt-4 ml-8"></div>
                </div>
                <p class="text-taupe text-lg md:text-xl max-w-4xl">
                    Explore our collection and find the perfect products to elevate your
                    beauty routine
                </p>
            </div> -->
            <!-- Search Section -->
            <form action="{{route('web.product.search')}}" method="GET" class="mb-8">
                <div class="search-container max-w-lg flex justify-start items-center bg-white rounded-2xl px-6 py-4 shadow-sm w-full">
                    <svg class="w-5 h-5 text-primary mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                    </svg>
                    <input name="q" id="productSearch" type="text" placeholder="Search for products..." 
                        class="flex-grow bg-transparent focus:outline-none text-gray-700 placeholder-gray-400" 
                        value="{{ $_GET['q'] ?? '' }}" />
                    <button type="submit" class="transition-transform duration-200 hover:scale-110 bg-primary text-white p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Filter Section -->
            <div class="flex flex-wrap justify-start gap-3 p-1 mb-10 overflow-x-auto pb-2">
                <a href="{{ route('web.products') }}" data-filter="all"
                    class="filter-btn flex-shrink-0 px-6 py-3 rounded-2xl font-semibold transition-all duration-300 {{ request()->routeIs('web.products') ? 'active-filter' : '' }}">
                    All Products
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('web.products.filterByCategory', ['slug' => $category->slug]) }}"
                        data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}"
                        class="filter-btn flex-shrink-0 px-6 py-3 rounded-2xl font-semibold transition-all duration-300 {{ request()->routeIs('web.products.filterByCategory') && request()->route('slug') == $category->slug ? 'active-filter' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="grid-container" id="productGrid">
                @foreach ($products as $product)
                    <div class="group relative product-card bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100"
                         data-product-id="{{ $product->id }}"
                         data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">

                        <!-- Animated Background Accent -->
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <div class="absolute -inset-1 bg-gradient-to-r from-primary/5 to-accent/5 blur-lg"></div>
                        </div>

                        <!-- Decorative Accent -->
                        <div class="hover-accent absolute -top-6 -right-6 z-10">
                            <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="70" cy="70" r="60" stroke="url(#gradient)" stroke-width="2" stroke-dasharray="8 8" fill="none"/>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ef380d" stop-opacity="0.6"/>
                                        <stop offset="100%" stop-color="#F3BF45" stop-opacity="0.4"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>

                        <!-- Badges -->
                        <div class="absolute top-6 left-6 z-20 flex flex-col gap-3">
                            @if($product->created_at && $product->created_at->diffInDays(now()) <= 50)
                                <span class="new-badge text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                    ✨ NEW
                                </span>
                            @endif
                            @if(isset($product->quantity))
                                <span class="quantity-badge text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                    🏷️ {{ $product->quantity }} left
                                </span>
                            @endif

                            {{-- Discount Badge --}}
                            @if ($product->getPrice() != $product->getOriginalPrice())
                                @php
                                    $discountAmount = $product->getOriginalPrice() - $product->getPrice();
                                    $discountPercentage = $product->getOriginalPrice() > 0 ? ($discountAmount / $product->getOriginalPrice()) * 100 : 0;
                                @endphp
                                <span class="discount-badge text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                    -{{ number_format($discountPercentage, 0) }}%
                                </span>
                            @endif
                        </div>

                        <!-- Share & Stock Section -->
                        <div class="absolute top-6 right-6 z-20 flex flex-col gap-3">
                            {{-- Share Button --}}
                            <div class="relative share-dropdown text-right">
                                <button class="share-toggle glass-effect text-gray-700 p-3 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 shadow-lg"
                                        title="Share Product">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                        </path>
                                    </svg>
                                </button>
                                
                                {{-- Share Options Dropdown --}}
                                <div class="share-options absolute top-full right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-200 min-w-[200px] opacity-0 invisible transform scale-95 transition-all duration-200 z-30">
                                    <div class="p-3">
                                        <p class="text-sm font-semibold text-gray-700 mb-3 px-2">Share this product</p>
                                        
                                        {{-- Social Media Share Options --}}
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('facebook', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-primary/5 rounded-xl transition-all duration-200">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                            <span class="font-medium">Facebook</span>
                                        </a>
                                        
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('twitter', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-primary/5 rounded-xl transition-all duration-200">
                                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                            <span class="font-medium">Twitter</span>
                                        </a>
                                        
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('whatsapp', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-primary/5 rounded-xl transition-all duration-200">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            <span class="font-medium">WhatsApp</span>
                                        </a>
                                        
                                        <div class="border-t border-gray-200 my-2"></div>
                                        
                                        {{-- Copy Link Option --}}
                                        <button onclick="copyProductLink('{{ route('web.products.details', $product->slug) }}')"
                                                class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-primary/5 rounded-xl transition-all duration-200 w-full text-left">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="font-medium">Copy Link</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Stock Status --}}
                            @if(isset($product->quantity))
                                <div class="stock-indicator glass-effect rounded-2xl px-4 py-2 shadow-lg">
                                    @if($product->quantity <= 5)
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
                                            <span class="text-xs font-semibold text-gray-700">Almost Out!</span>
                                        </div>
                                    @elseif($product->quantity <= 20)
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                            <span class="text-xs font-semibold text-gray-700">Low Stock</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                            <span class="text-xs font-semibold text-gray-700">In Stock</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Product Image -->
                        <div class="relative h-72 md:h-80 overflow-hidden">
                            <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="product-image w-full h-full object-cover"
                                    onerror="this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop'">
                            </a>

                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Quick Action Overlay -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="text-white font-semibold text-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    View Details
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6 relative z-20 bg-white">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300 flex-1 pr-4">
                                    <a href="{{route('web.products.details', ['slug' => $product->slug])}}">{{ $product->name }}</a>
                                </h3>
                                @if($product->category)
                                    <span class="category-badge text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>

                            @if(isset($product->description))
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {!! Str::limit($product->description, 100) !!}
                                </p>
                            @endif

                            @if(isset($product->weight) && $product->weight > 0)
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                    </svg>
                                    Weight: {{ $product->weight }}kg
                                </div>
                            @endif

                            <!-- Price and Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="price-tag text-white font-bold text-lg px-5 py-2 rounded-xl shadow-lg">
                                    @if ($product->getPrice() != $product->getOriginalPrice())
                                        <span class="block text-xs text-gray-300 line-through text-right">
                                            {{ app_currency() }} {{ number_format($product->getOriginalPrice(), 2) }}
                                        </span>
                                        <span class="text-lg">
                                            {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                                        </span>
                                    @else
                                        <span class="text-lg">
                                            {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex gap-3">
                                    @if(!isset($product->quantity) || $product->quantity > 0)
                                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1, 'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0]) }}"
                                            class="cart-button bg-primary text-primary-light px-5 py-3 rounded-xl hover:bg-primary-dark transition-all duration-300 hover:scale-110 text-sm font-semibold flex items-center justify-center shadow-lg">
                                            Buy Now
                                        </a>

                                        <button
                                            class="cart-button cart-item-btn bg-white text-primary p-3 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 shadow-lg border border-primary/20"
                                            data-product-id="{{ $product->id }}" 
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ number_format($product->getPrice(), 2) }}"
                                            data-product-image="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png')  }}" 
                                            title="Add to Cart">
                                            <div class="loading-spinner hidden"></div>
                                            <svg class="w-5 h-5 cart-icon" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button class="cart-button bg-gray-300 text-gray-500 p-3 rounded-xl cursor-not-allowed shadow-lg"
                                            disabled title="Out of Stock">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif

                                    <a href="{{ route('web.products.details', $product->slug) }}"
                                        class="cart-button bg-white text-gray-600 p-3 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 shadow-lg border border-gray-200"
                                        title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center space-x-3 mt-12">
                <a href="{{ $products->previousPageUrl() }}"
                    class="pagination-button text-primary font-bold px-6 py-3 rounded-2xl transition-all duration-300 flex items-center space-x-2 {{ $products->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                    <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m7.41 11.572-4.58-4.59 4.58-4.59L6 .982l-6 6 6 6z" fill="currentColor"></path>
                    </svg>
                    <span class="ml-2">Previous</span>
                </a>

                @php
                    $current = $products->currentPage();
                    $last = $products->lastPage();
                @endphp

                <div class="flex space-x-2 text-gray-600">
                    {{-- First page --}}
                    @if ($current > 3)
                        <a href="{{ $products->url(1) }}"
                            class="pagination-button px-4 py-2 rounded-2xl font-semibold transition-all duration-300">
                            1
                        </a>
                        @if ($current > 4)
                            <span class="px-3 py-2 text-gray-400">...</span>
                        @endif
                    @endif

                    {{-- Pages around current --}}
                    @for ($i = max(1, $current - 2); $i <= min($last, $current + 2); $i++)
                        <a href="{{ $products->url($i) }}"
                            class="pagination-button px-4 py-2 rounded-2xl font-semibold transition-all duration-300 {{ $i === $current ? 'active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Last page --}}
                    @if ($current < $last - 2)
                        @if ($current < $last - 3)
                            <span class="px-3 py-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $products->url($last) }}"
                            class="pagination-button px-4 py-2 rounded-2xl font-semibold transition-all duration-300">
                            {{ $last }}
                        </a>
                    @endif
                </div>

                <a href="{{ $products->nextPageUrl() }}"
                    class="pagination-button text-primary font-bold px-6 py-3 rounded-2xl transition-all duration-300 flex items-center space-x-2 {{ $products->currentPage() == $products->lastPage() ? 'pointer-events-none opacity-50' : '' }}">
                    <span class="mr-2">Next</span>
                    <svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m.824 2.392 4.58 4.59-4.58 4.59 1.41 1.41 6-6-6-6z" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <script>
        // Share functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle share dropdown
            document.querySelectorAll('.share-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = this.nextElementSibling;
                    const isVisible = !dropdown.classList.contains('opacity-0');
                    
                    // Close all other dropdowns
                    document.querySelectorAll('.share-options').forEach(d => {
                        d.classList.add('opacity-0', 'invisible', 'scale-95');
                    });
                    
                    // Toggle current dropdown
                    if (!isVisible) {
                        dropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                        dropdown.classList.add('opacity-100', 'visible', 'scale-100');
                    }
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.share-dropdown')) {
                    document.querySelectorAll('.share-options').forEach(dropdown => {
                        dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                    });
                }
            });
        });

        // Share product function
        function shareProduct(platform, url, title, description) {
            const encodedUrl = encodeURIComponent(url);
            const encodedTitle = encodeURIComponent(title);
            const encodedDescription = encodeURIComponent(description);
            
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
        }

        // Copy product link function
        function copyProductLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                
                button.innerHTML = `
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-green-600 font-semibold">Copied!</span>
                `;
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 2000);
                
                // Close dropdown
                document.querySelectorAll('.share-options').forEach(dropdown => {
                    dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                });
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                alert('Link copied to clipboard!');
            });
        }
    </script>
@endsection