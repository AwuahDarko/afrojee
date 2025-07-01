<style>
    :root {
        --burgundy: #800020;
        --taupe: #8B7355;
        --gold: #F3BF45;
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
        transform: translateY(-12px) scale(1.02);
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
        background: linear-gradient(135deg, var(--burgundy), #a0002a);
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
</style>

<!-- Header Section -->
<section class="py-16 px-4 md:px-8">
    <div class="container mx-auto max-w-7xl">
        <!-- Section Heading -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe">
                    Our <br><span class="font-bold">Products</span>
                </h1>
                <div class="bg-taupe h-1 w-full min-w-32 mt-4 ml-8"></div>
            </div>
            <p class="text-taupe text-lg md:text-xl max-w-4xl">
                Discover our exclusive range of premium skincare essentials, crafted to keep your routine simple and
                effective
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid-container" id="productsGrid">
            @forelse($featured_products as $product)
                <div class="group relative product-card bg-white rounded-2xl shadow-lg overflow-hidden"
                    data-product-id="{{ $product->id }}">
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
                        @if($product->created_at->diffInDays(now()) <= 50)
                            <span class="new-badge text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                        @endif
                        <span class="quantity-badge text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $product->quantity }} left
                        </span>
                    </div>

                    <!-- Stock Status -->
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

                    <!-- Product Image -->
                    <div class="relative h-64 md:h-72 overflow-hidden">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="product-image w-full h-full object-cover"
                            onerror="this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop'">

                        <!-- Overlay on hover -->
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-xl font-bold text-gray-800 group-hover:text-burgundy transition-colors flex-1">
                                {{ $product->name }}
                            </h3>
                            @if($product->category)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full ml-2">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {!! Str::limit($product->description, 100) !!}
                        </p>

                        <!-- Weight Display -->
                        @if($product->weight > 0)
                            <div class="text-xs text-gray-500 mb-3">
                                Weight: {{ $product->weight }}kg
                            </div>
                        @endif

                        <!-- Price and Actions -->
                        <div class="flex items-center justify-between">
                            <div class="price-tag text-white font-bold text-lg px-4 py-2 rounded-l-lg">
                                {{app_currency()}} {{ number_format($product->price, 2) }}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                @if($product->quantity > 0)
                                    <button id="add-to-cart-button"
                                        class="cart-button cart-item-btn bg-burgundy text-white p-3 rounded-full hover:bg-opacity-90 transition-all duration-300 hover:scale-110"
                                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                        data-product-price="{{ number_format($product->price, 2) }}"
                                        data-product-image="{{ $product->image }}" title="Add to Cart">
                                        <div class="loading-spinner hidden"></div>
                                        <svg class="w-5 h-5 cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8-9M7 13l-1.8-9m0 0L3 3m4 10v6a2 2 0 002 2h6a2 2 0 002-2v-6M9 19h6">
                                            </path>
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
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Products Found</h3>
                    <p class="text-gray-500">We're working on adding new products. Check back soon!</p>
                </div>
            @endforelse
        </div>

        <!-- View All Products Button -->
        @if($featured_products->count() > 0)
            <div class="flex justify-end mt-12">
                <a href="{{ route('web.products') }}"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-full border-2 border-burgundy text-burgundy hover:bg-burgundy hover:text-white transition-colors">
                    View All Products
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>