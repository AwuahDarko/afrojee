@extends('frontend.layouts.app')

@section('title')
    Afrojee - Browse our products
@endsection

@section('content')
    <style>
        :root {
            --burgundy: #800020;
            --taupe: #8B7355;
            --gold: #F3BF45;
            --pink-800: #99395C;
        }

        .text-burgundy {
            color: var(--burgundy);
        }

        .bg-burgundy {
            background-color: var(--burgundy);
        }

        .border-burgundy {
            border-color: var(--burgundy);
        }

        .text-taupe {
            color: var(--taupe);
        }

        .bg-taupe {
            background-color: var(--taupe);
        }

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .product-card:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            transition: all 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.1);
        }

        .cart-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(10px);
            opacity: 0;
        }

        .product-card:hover .cart-button {
            transform: translateY(0);
            opacity: 1;
        }

        .quantity-badge {
            background: linear-gradient(135deg, var(--gold), #e6ac39);
            animation: pulse 2s infinite;
        }

        .new-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            animation: shimmer 2s ease-in-out infinite alternate;
        }

        .share-dropdown .share-options {
            transition: all 0.2s ease-in-out;
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
        
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
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
            opacity: 0.7;
            transform: scale(1) rotate(0deg);
        }

        .price-tag {
            background: linear-gradient(135deg, var(--pink-800), #b8457a);
            clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%);
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--burgundy);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .filter-btn {
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 57, 92, 0.2);
        }

        .search-container {
            transition: all 0.3s ease;
        }

        .search-container:focus-within {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(139, 115, 85, 0.15);
        }

        .pagination-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 57, 92, 0.2);
        }
    </style>

    <section class="bg-[#f7f3e9] py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-12">
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
            </div>

            <!-- Search Section -->
            <form action="{{route('web.product.search')}}" method="GET" class="mb-8">
                <div
                    class="search-container max-w-lg flex justify-start items-center bg-white border border-gray-300 rounded-lg px-4 py-3 shadow-sm w-full">
                    <input name="q" id="productSearch" type="text" placeholder="Enter product to search"
                        class="flex-grow bg-transparent focus:outline-none text-gray-700" value="{{ $_GET['q'] ?? '' }}" />
                    <button type="submit" class="transition-transform duration-200 hover:scale-110">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Filter Section -->
            <div class="flex flex-wrap justify-start gap-4 p-1 mb-10 overflow-x-auto pb-2">
                <a href="{{ route('web.products') }}" data-filter="all"
                    class="filter-btn flex-shrink-0 px-6 py-3 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-all duration-300 {{ request()->routeIs('web.products') ? 'active-filter bg-pink-100' : '' }}">
                    All Products
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('web.products.filterByCategory', ['slug' => $category->slug]) }}"
                        data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}"
                        class="filter-btn flex-shrink-0 px-6 py-3 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-all duration-300 {{ request()->routeIs('web.products.filterByCategory') && request()->route('slug') == $category->slug ? 'active-filter bg-pink-100' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="grid-container" id="productGrid">
                @foreach ($products as $product)
                   <div class="group relative product-card bg-secondary rounded-2xl shadow-lg overflow-hidden"
                        data-product-id="{{ $product->id }}"
                        data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">

                        <div class="hover-accent absolute -top-4 -left-4 z-10">
                            <svg width="120" height="60" viewBox="0 0 231 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.6">
                                    <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473" stroke="#F3BF45"
                                        stroke-width="8" stroke-linecap="round" />
                                    <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272" stroke="#F3BF45"
                                        stroke-width="8" stroke-linecap="round" />
                                </g>
                            </svg>
                        </div>

                        <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
                            @if($product->created_at && $product->created_at->diffInDays(now()) <= 50)
                                <span class="new-badge text-white text-xs font-bold px-3 py-1 rounded-full bg-blue-500">NEW</span>
                            @endif
                            @if(isset($product->quantity))
                                <span class="quantity-badge text-white text-xs font-bold px-3 py-1 rounded-full bg-purple-500">
                                    {{ $product->quantity }} left
                                </span>
                            @endif

                            {{-- NEW: Discount Badge --}}
                            @if ($product->getPrice() != $product->getOriginalPrice())
                                @php
                                    $discountAmount = $product->getOriginalPrice() - $product->getPrice();
                                    // Ensure original price is not zero to prevent division by zero
                                    $discountPercentage = $product->getOriginalPrice() > 0 ? ($discountAmount / $product->getOriginalPrice()) * 100 : 0;
                                @endphp
                                <span class="discount-badge text-white text-xs font-bold px-3 py-1 rounded-full bg-red-600">
                                    -{{ number_format($discountPercentage, 0) }}%
                                </span>
                            @endif
                        </div>

                        <div class="absolute top-4 right-4 z-20 flex flex-col gap-2">
                            {{-- Share Button --}}
                            <div class="relative share-dropdown text-right">
                                <button class="share-toggle bg-white/90 backdrop-blur-sm text-gray-700 p-2 rounded-full hover:bg-white transition-all duration-300 hover:scale-110"
                                        title="Share Product">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                        </path>
                                    </svg>
                                </button>
                                
                                {{-- Share Options Dropdown --}}
                                <div class="share-options absolute top-full right-0 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 min-w-[200px] opacity-0 invisible transform scale-95 transition-all duration-200 z-30">
                                    <div class="p-2">
                                        <p class="text-xs text-gray-500 font-medium mb-2 px-2">Share this product</p>
                                        
                                        {{-- Social Media Share Options --}}
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('facebook', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                            Facebook
                                        </a>
                                        
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('twitter', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                                            <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                            Twitter
                                        </a>
                                        
                                        <a href="javascript:void(0)" 
                                           onclick="shareProduct('whatsapp', '{{ route('web.products.details', $product->slug) }}', '{{ $product->name }}', '{{ $product->description ?? '' }}')"
                                           class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            WhatsApp
                                        </a>
                                        
                                        <div class="border-t border-gray-200 my-2"></div>
                                        
                                        {{-- Copy Link Option --}}
                                        <button onclick="copyProductLink('{{ route('web.products.details', $product->slug) }}')"
                                                class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors w-full text-left">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Copy Link
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Stock Status --}}
                            @if(isset($product->quantity))
                                <div class="flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1">
                                    @if($product->quantity <= 5)
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                        <span class="text-xs font-medium text-gray-700">Almost Out!</span>
                                    @elseif($product->quantity <= 20)
                                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                        <span class="text-xs font-medium text-gray-700">Low Stock</span>
                                    @else
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                        <span class="text-xs font-medium text-gray-700">In Stock</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="relative h-64 md:h-72 overflow-hidden">
                            <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="product-image w-full h-full object-cover"
                                    onerror="this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop'">
                            </a>

                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-burgundy transition-colors flex-1">
                                    <a
                                        href="{{route('web.products.details', ['slug' => $product->slug])}}">{{ $product->name }}</a>
                                </h3>
                                @if($product->category)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full ml-2">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>

                            @if(isset($product->description))
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {!! Str::limit($product->description, 100) !!}
                                </p>
                            @endif

                            @if(isset($product->weight) && $product->weight > 0)
                                <div class="text-xs text-gray-500 mb-3">
                                    Weight: {{ $product->weight }}kg
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                {{-- Price Display (as per previous discussion) --}}
                                <div class="price-tag text-white font-bold px-4 py-2 rounded-l-lg truncate">
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

                                <div class="flex gap-2">
                                    @if(!isset($product->quantity) || $product->quantity > 0)
                                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1]) }}"
                                            class="cart-button bg-pink-800 text-white px-4 py-2 rounded-full hover:bg-pink-900 transition-all duration-300 hover:scale-110 text-xs font-medium flex items-center justify-center">
                                            Buy Now
                                        </a>

                                        <button
                                            class="cart-button cart-item-btn bg-burgundy text-white p-3 rounded-full hover:bg-opacity-90 transition-all duration-300 hover:scale-110"
                                            data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                            data-product-price="{{ number_format($product->getPrice(), 2) }}"
                                            data-product-image="{{ $product->image }}" title="Add to Cart">
                                            <div class="loading-spinner hidden"></div>
                                            <svg width="20" class="w-5 h-5 cart-icon" stroke="currentColor" height="20"
                                                viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#a)" fill="#fff">
                                                    <path
                                                        d="M21.25 22.5a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.113-2.5 2.5-2.5m-20-20h4.088L6.513 5H25a1.25 1.25 0 0 1 1.25 1.25c0 .213-.062.425-.15.625l-4.475 8.088a2.51 2.51 0 0 1-2.187 1.287h-9.313L9 18.288l-.037.15a.313.313 0 0 0 .312.312H23.75v2.5h-15a2.5 2.5 0 0 1-2.5-2.5c0-.437.112-.85.3-1.2l1.7-3.062L3.75 5h-2.5zm7.5 20a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.112-2.5 2.5-2.5M20 13.75l3.475-6.25h-15.8l2.95 6.25z" />
                                                    <path d="M25 15.5v6h6v4h-6v6h-4v-6h-6v-4h6v-6z" stroke="#F4F3E7"
                                                        stroke-width="1" />
                                                </g>
                                                <defs>
                                                    <clipPath id="a">
                                                        <path fill="#fff" d="M0 0h30v30H0z" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                    @else
                                        <button class="cart-button bg-gray-400 text-white p-3 rounded-full cursor-not-allowed"
                                            disabled title="Out of Stock">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif

                                    <a href="{{ route('web.products.details', $product->slug) }}"
                                        class="cart-button bg-taupe text-white p-2 rounded-full hover:bg-opacity-90 flex items-center justify-center transition-all duration-300 hover:scale-110"
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
            <div class="flex justify-center items-center space-x-2 mt-12">
                <a href="{{ $products->previousPageUrl() }}"
                    class="pagination-button text-pink-800 font-bold px-6 py-3 rounded-full border border-transparent hover:border-pink-800 transition-all duration-300 flex items-center space-x-2 {{ $products->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
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
                            class="pagination-button px-4 py-2 rounded-full font-medium border border-transparent hover:border-pink-800 transition-all duration-300">
                            1
                        </a>
                        @if ($current > 4)
                            <span class="px-2 py-1">...</span>
                        @endif
                    @endif

                    {{-- Pages around current --}}
                    @for ($i = max(1, $current - 2); $i <= min($last, $current + 2); $i++)
                        <a href="{{ $products->url($i) }}"
                            class="pagination-button px-4 py-2 rounded-full font-medium border border-transparent hover:border-pink-800 transition-all duration-300 {{ $i === $current ? 'bg-pink-800 text-white' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Last page --}}
                    @if ($current < $last - 2)
                        @if ($current < $last - 3)
                            <span class="px-2 py-1">...</span>
                        @endif
                        <a href="{{ $products->url($last) }}"
                            class="pagination-button px-4 py-2 rounded-full font-medium border border-transparent hover:border-pink-800 transition-all duration-300">
                            {{ $last }}
                        </a>
                    @endif
                </div>

                <a href="{{ $products->nextPageUrl() }}"
                    class="pagination-button text-pink-800 font-bold px-6 py-3 rounded-full border border-transparent hover:border-pink-800 transition-all duration-300 flex items-center space-x-2 {{ $products->currentPage() == $products->lastPage() ? 'pointer-events-none opacity-50' : '' }}">
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
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-green-600">Copied!</span>
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