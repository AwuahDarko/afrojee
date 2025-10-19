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

        <div class="mb-16 max-w-3xl">
            <p class="text-stone-700 text-lg">
                Discover our exclusive range of premium skincare essentials, crafted to keep your routine simple and
                effective
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
        <div class="grid-container" id="productsGrid">
            @forelse($featured_products as $product)
                <div class="group relative product-card bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100"
                    data-product-id="{{ $product->id }}">

                    <!-- Main Card Link (z-30) -->
                    <a href="{{ route('web.products.details', $product->slug) }}"
                        class="absolute inset-0 z-30 pointer-events-auto"
                        aria-label="View {{ $product->name }} details"></a>

                    <!-- Animated Background Accent -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <div class="absolute -inset-1 bg-gradient-to-r from-primary/5 to-accent/5 blur-lg"></div>
                    </div>

                    <!-- Decorative Accent -->
                    <div class="hover-accent absolute -top-6 -right-6 z-10">
                        <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="70" cy="70" r="60" stroke="url(#gradient)" stroke-width="2" stroke-dasharray="8 8"
                                fill="none" />
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ef380d" stop-opacity="0.6" />
                                    <stop offset="100%" stop-color="#F3BF45" stop-opacity="0.4" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>

                    <!-- Badges -->
                    <div class="absolute top-6 left-6 z-40 flex flex-col gap-3">
                        @if($product->created_at->diffInDays(now()) <= 10)
                            <span class="new-badge text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                ✨ NEW
                            </span>
                        @endif
                        <span class="quantity-badge text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                            🏷️ {{ $product->quantity }} left
                        </span>
                    </div>

                    <!-- Stock Status -->
                    <div class="absolute top-6 right-6 z-40">
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
                    </div>

                    <!-- Product Image -->
                    <div class="relative h-72 md:h-80 overflow-hidden">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="product-image w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/300x300/F3BF45/ffffff?text=Product+Image'">

                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Quick Action Overlay -->
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span
                                class="text-white font-semibold text-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                View Product
                            </span>
                        </div>
                    </div>

                    <!-- Product Info (Changed to z-40) -->
                    <div class="p-6 relative z-40 bg-white">
                        <div class="flex items-start justify-between mb-3">
                            <h3
                                class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300 flex-1 pr-4">
                                {{ $product->name }}
                            </h3>
                            @if($product->category)
                                <span class="category-badge text-xs font-semibold px-3 py-1 rounded-full whitespace-nowrap">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {!! Str::limit($product->description, 100) !!}
                        </p>

                        <!-- Weight Display -->
                        @if($product->weight > 0)
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                                Weight: {{ $product->weight }}kg
                            </div>
                        @endif

                        <!-- Price and Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="price-tag text-white font-bold text-lg px-5 py-2 rounded-xl shadow-lg">
                                {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                            </div>

                            <!-- Action Buttons (Changed to z-50) -->
                            <div class="flex gap-3 relative z-50">
                                @if($product->quantity > 0)
                                    <button
                                        class="cart-button cart-item-btn bg-white text-primary p-3 rounded-xl hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 shadow-lg border border-primary/20"
                                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                        data-product-price="{{ number_format($product->getPrice(), 2) }}"
                                        data-product-image="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png')  }}" title="Add to Cart">
                                        <div class="loading-spinner hidden"></div>
                                        <svg class="w-5 h-5 cart-icon" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                @else
                                    <button
                                        class="cart-button bg-gray-300 text-gray-500 p-3 rounded-xl cursor-not-allowed shadow-lg"
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
