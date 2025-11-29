<style>
    :root {
        --primary: #ef380d;
        --primary-dark: #d6320c;
        --primary-light: #f06243ff;
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

    .bg-primary-light {
        background-color: var(--primary-light);
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
        background: linear-gradient(145deg, #fffaf8, #ffe8e3);
        border: 1px solid rgba(239, 56, 13, 0.1);
    }

    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow:
            0 25px 50px -12px rgba(239, 56, 13, 0.15),
            0 0 0 1px rgba(239, 56, 13, 0.1);
        border-color: rgba(239, 56, 13, 0.2);
        background: linear-gradient(145deg, #ffe8e3, #ffd4c9);
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

    .category-badge {
        background: linear-gradient(135deg, var(--primary-light), rgba(239, 56, 13, 0.15));
        color: var(--primary-dark);
        border: 1px solid rgba(239, 56, 13, 0.2);
    }

    @keyframes pulse {

        0%,
        100% {
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

        0%,
        100% {
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
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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

    .glass-effect {
        backdrop-filter: blur(16px) saturate(180%);
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<!-- Header Section -->
<section class="py-16 px-4 md:px-8 bg-gradient-to-br from-white to-orange-50/30">
    <div class="container mx-auto max-w-7xl">
        <!-- Section Heading -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row items-center justify-items-start">
                <h1 class="text-4xl md:text-5xl lg:text-6xl min-w-[26%] text-left">
                    <span class="block font-light text-primary">Our</span>
                    <span class="block font-bold text-primary">Products</span>
                </h1>
                <div class="w-full h-1 bg-primary-light mt-4 md:mt-0"></div>
            </div>
        </div>

        <div class="mb-10 max-w-3xl">
            <p class="text-stone-700 text-lg">
            Discover our exclusive range of premium hair care essentials, crafted to keep your routine simple, healthy, and effortlessly beautiful.
            </p>
        </div>
        <!-- View All Products Button -->
        @if($featured_products->count() > 0)
            <div class="flex justify-end mb-12">
                <a href="{{ route('web.products') }}"
                    class="group inline-flex items-center justify-center px-8 py-4 rounded-2xl border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <span class="font-semibold">View All Products</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="productsGrid">
            @forelse($featured_products as $product)
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
                <div class="col-span-full text-center py-16">
                    <div class="text-gray-300 mb-6">
                        <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">No Products Available</h3>
                    <p class="text-gray-500 text-lg max-w-md mx-auto">
                        We're currently refreshing our collection with amazing new products. Stay tuned for updates!
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>
