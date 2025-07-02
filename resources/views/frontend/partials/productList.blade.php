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
            <div class="flex flex-wrap justify-start gap-4 mb-10 overflow-x-auto pb-2">
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

                        <!-- Decorative Accent -->
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

                        <!-- Badges -->
                        <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
                            @if($product->created_at && $product->created_at->diffInDays(now()) <= 50)
                                <span class="new-badge text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                            @endif
                            @if(isset($product->quantity))
                                <span class="quantity-badge text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $product->quantity }} left
                                </span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        @if(isset($product->quantity))
                            <div class="absolute top-4 right-4 z-20">
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
                            </div>
                        @endif

                        <!-- Product Image -->
                        <div class="relative h-64 md:h-72 overflow-hidden">
                            <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="product-image w-full h-full object-cover"
                                    onerror="this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop'">
                            </a>

                            <!-- Overlay on hover -->
                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <!-- Product Info -->
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

                            <!-- Weight Display -->
                            @if(isset($product->weight) && $product->weight > 0)
                                <div class="text-xs text-gray-500 mb-3">
                                    Weight: {{ $product->weight }}kg
                                </div>
                            @endif

                            <!-- Price and Actions -->
                            <div class="flex items-center justify-between">
                                <div class="price-tag text-white font-bold px-4 py-2 rounded-l-lg truncate relative">
                                    @if ($product->getPrice() != $product->getOriginalPrice())
                                        {{-- Display original price small on top --}}
                                        <span class="block text-sm text-gray-300 line-through mb-1">
                                            {{ app_currency() }} {{ number_format($product->getOriginalPrice(), 2) }}
                                        </span>

                                        {{-- Display current (discounted) price large --}}
                                        <span class="text-xl">
                                            {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                                        </span>

                                        {{-- Calculate and display the discount badge --}}
                                        @php
                                            $discountAmount = $product->getOriginalPrice() - $product->getPrice();
                                            $discountPercentage = ($discountAmount / $product->getOriginalPrice()) * 100;
                                        @endphp
                                        <span
                                            class="absolute top-0 right-0 mt-2 -mr-8 bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-md">
                                            -{{ number_format($discountPercentage, 0) }}%
                                        </span>
                                    @else
                                        {{-- Display regular price (no discount) --}}
                                        <span class="text-lg">
                                            {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    @if(!isset($product->quantity) || $product->quantity > 0)
                                        <!-- Buy Now Button -->
                                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1]) }}"
                                            class="cart-button bg-pink-800 text-white px-4 py-2 rounded-full hover:bg-pink-900 transition-all duration-300 hover:scale-110 text-sm font-medium">
                                            Buy Now
                                        </a>

                                        <!-- Add to Cart Button -->
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

                                    <!-- View Details Button -->
                                    <a href="{{ route('web.products.details', $product->slug) }}"
                                        class="cart-button bg-taupe text-white p-3 rounded-full hover:bg-opacity-90 transition-all duration-300 hover:scale-110"
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
@endsection