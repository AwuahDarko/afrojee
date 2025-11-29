@php
    $checkoutUrl = route('web.checkoutDetails.single', [
        'product_id' => $product->id,
        'quantity' => 1,
        'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0,
    ]);
    
    // Prepare discount information
    $activePromo = $product->getActivePromo();
    $hasDiscount = $product->hasDiscount();
    $discountType = null;
    $discountValue = null;
    
    if ($hasDiscount && $activePromo) {
        $discountType = $activePromo->discount_type;
        $discountValue = (float) $activePromo->discount;
    }
    
    // Prepare sizes data with original and discounted prices
    $sizesData = [];
    if ($product->sizes->isNotEmpty()) {
        foreach ($product->sizes as $size) {
            $originalPrice = (float) $size->price;
            $discountedPrice = $product->applyDiscount($originalPrice);
            $sizesData[] = [
                'id' => $size->id,
                'size' => $size->size,
                'originalPrice' => $originalPrice,
                'discountedPrice' => $discountedPrice,
                'hasDiscount' => $hasDiscount && ($originalPrice != $discountedPrice)
            ];
        }
    }
@endphp
<script>
    const checkoutRoute = @json($checkoutUrl);
    const productReviews = @json($product->reviews);
    
    // Discount information
    const productDiscount = {
        hasDiscount: @json($hasDiscount),
        discountType: @json($discountType),
        discountValue: @json($discountValue)
    };
    
    // Sizes data with prices
    const productSizes = @json($sizesData);
    const currency = @json(app_currency());

</script>
<script src="{{ asset('js/productDetail.js') }}"></script>

@extends('frontend.layouts.app')

@section('title')
    {{ $product->name }} | Afrojee
@endsection

@section('meta_title'){{ $product->name }}@stop

@section('meta_description'){{ $meta_description }}@stop

@section('meta_keywords'){{ $meta_keywords }}@stop

@section('meta')
    <meta itemprop="name" content="{{ $product->name }}">
    <meta itemprop="description" content="{{ $meta_description }}">
    <meta itemprop="image" content="{{ $product->image }}">

    @if ($product->getPrice() != $product->getOriginalPrice())
        <meta name="twitter:data1" content="{{ app_currency() . number_format($product->getPrice(), 2) }}">
        <meta name="twitter:label1" content="Sale Price">
        <meta name="twitter:data2" content="{{ app_currency() . number_format($product->getOriginalPrice(), 2) }}">
        <meta name="twitter:label2" content="Original Price">
        <meta name="twitter:description"
            content="{{ $meta_description }} - Save now! Original Price: {{ app_currency() }}{{ number_format($product->getOriginalPrice(), 2) }}">
    @else
        <meta name="twitter:data1" content="{{ app_currency() . number_format($product->getPrice(), 2) }}">
        <meta name="twitter:label1" content="Price">
        <meta name="twitter:description" content="{{ $meta_description }}">
    @endif

    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('web.products.details', ['slug' => $product->slug]) }}" />
    <meta property="og:image" content="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png')  }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />

    @if ($product->getPrice() != $product->getOriginalPrice())
        <meta property="og:price:amount" content="{{ number_format($product->getPrice(), 2) }}" />
        <meta property="og:price:currency" content="EUR" />
        <meta property="og:price:standard_amount" content="{{ number_format($product->getOriginalPrice(), 2) }}" />
        <meta property="og:price:standard_currency" content="EUR" />
    @else
        <meta property="og:price:amount" content="{{ number_format($product->getPrice(), 2) }}" />
        <meta property="og:price:currency" content="EUR" />
    @endif
@endsection
@section('content')
    <section class="bg-white py-8 px-4 md:py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-6 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-gray-900">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('web.products') }}" class="hover:text-gray-900">Products</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->name }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left Column - Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="relative aspect-square bg-gray-50 rounded-2xl overflow-hidden">
                        @php
                            $primary = $product->getPrimaryImage() ?? $product->images->first();
                            $initialImage = $primary ? $primary->image_path : ($product->image ?? asset('images/default-product.png'));
                        @endphp
                        <img id="main-product-image" src="{{ $initialImage }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->images->isNotEmpty())
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $image)
                                <button type="button" onclick="changeMainImage('{{ $image->image_path }}')"
                                    class="thumbnail-btn aspect-square rounded-lg overflow-hidden border-2 transition-all {{ $loop->first ? 'border-gray-900' : 'border-gray-200 hover:border-gray-400' }}">
                                    <img src="{{ $image->image_path }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column - Product Info -->
                <div class="space-y-6">
                    <!-- Sale Badge -->
                    @if($product->getPrice() != $product->getOriginalPrice())
                        <span class="inline-block px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-full">
                            Discount Sale
                        </span>
                    @endif

                    <!-- Pricing -->
                    <div class="flex items-center gap-3" id="pricing-container">
                        <!-- <span class="text-gray-400 line-through text-xl " id="original-price-display">
                             {{ number_format($product->getOriginalPrice(), 2) }} {{ app_currency() }}
                        </span> -->
                        @if($product->getPrice() != $product->getOriginalPrice())
                            <span class="text-gray-400 line-through text-xl " id="original-price-display">
                                {{ number_format($product->getOriginalPrice(), 2) }} {{ app_currency() }}
                            </span>
                        @endif
                        <span class="text-3xl font-bold text-gray-900" id="display-price">
                             {{ number_format($product->getPrice(), 2) }} {{ app_currency() }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-4xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <!-- Rating -->
                    @if($product->reviews_count > 0)
                        <div class="flex items-center gap-2">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'fill-current' : 'fill-gray-300' }}"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-gray-600 font-medium">{{ number_format($product->average_rating, 1) }}
                                ({{ $product->reviews_count }} reviews)</span>
                        </div>
                    @endif

                    <!-- Size Selection -->
                    @if($product->sizes->isNotEmpty())
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="font-semibold text-gray-900">Size:</span>
                                <span class="text-gray-600"
                                    id="selected-size-display">{{ $product->sizes->first()->size }}</span>
                            </div>
                            <div class="flex gap-2">
                                @foreach($product->sizes as $size)
                                    @php
                                        $originalPrice = (float) $size->price;
                                        $discountedPrice = $product->applyDiscount($originalPrice);
                                    @endphp
                                    <button type="button"
                                        onclick="selectSize({{ $size->id }}, '{{ $size->size }}', {{ $originalPrice }}, {{ $discountedPrice }})"
                                        data-size-id="{{ $size->id }}"
                                        data-original-price="{{ $originalPrice }}"
                                        data-discounted-price="{{ $discountedPrice }}"
                                        class="size-btn px-6 py-3 border-2 rounded-lg font-medium transition {{ $loop->first ? 'border-gray-900 bg-gray-900 text-white' : 'border-gray-300 hover:border-gray-400' }}">
                                        {{ $size->size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quantity & Actions -->
                    <div class="space-y-4">
                        <span class="font-semibold text-gray-900">Quantity</span>

                        <div class="flex gap-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border-2 border-gray-300 rounded-lg">
                                <button type="button" id="decrement" class="p-3 hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" id="quantity" value="1" min="1"
                                    class="w-16 text-center font-semibold text-lg border-none focus:outline-none" readonly>
                                <button type="button" id="increment" class="p-3 hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button"
                                class="cart-item-btn flex-1 bg-gray-900 text-white py-4 rounded-lg font-semibold hover:bg-gray-800 transition"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->price : $product->price }}"
                                data-product-image="{{ $initialImage }}"
                                data-size-id="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0 }}">
                                Add to cart
                            </button>
                        </div>

                        <!-- Buy Now Button -->
                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1, 'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0]) }}"
                            id="buy-now-link"
                            class="block w-full bg-white border-2 border-gray-900 text-gray-900 py-4 rounded-lg font-semibold text-center hover:bg-gray-50 transition">
                            Buy it now
                        </a>
                    </div>

                    <!-- Action Links -->
                    <div class="flex items-center gap-6 pt-4 border-t">
    <button type="button" class="flex hidden items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span class="font-medium">Add To Wishlist</span>
    </button>
    
    <div class="share-dropdown relative">
        <button type="button" id="share-toggle" class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
            </svg>
            <span class="font-medium">Share</span>
        </button>
        
        <div class="share-menu hidden absolute top-full left-0 mt-2 bg-white rounded-xl shadow-lg p-5 min-w-[280px] z-50">
            <div class="font-semibold text-sm text-gray-900 mb-3">Share this product</div>
            <div class="flex gap-3">
                <a href="#" onclick="shareProduct('facebook', '{{ route('web.products.details', $product->slug) }}', '{{ addslashes($product->name) }}'); return false;" 
                   class="flex-1 flex items-center justify-center p-3 bg-gray-100 rounded-lg hover:bg-[#1877f2] hover:text-white transition-all duration-200 hover:-translate-y-0.5" 
                   title="Share on Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" onclick="shareProduct('twitter', '{{ route('web.products.details', $product->slug) }}', '{{ addslashes($product->name) }}'); return false;" 
                   class="flex-1 flex items-center justify-center p-3 bg-gray-100 rounded-lg hover:bg-[#1da1f2] hover:text-white transition-all duration-200 hover:-translate-y-0.5" 
                   title="Share on Twitter">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="#" onclick="shareProduct('whatsapp', '{{ route('web.products.details', $product->slug) }}', '{{ addslashes($product->name) }}'); return false;" 
                   class="flex-1 flex items-center justify-center p-3 bg-gray-100 rounded-lg hover:bg-[#25d366] hover:text-white transition-all duration-200 hover:-translate-y-0.5" 
                   title="Share on WhatsApp">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
                <button type="button" onclick="copyProductLink('{{ route('web.products.details', $product->slug) }}')" 
                        class="flex-1 flex items-center justify-center p-3 bg-gray-100 rounded-lg hover:bg-indigo-500 hover:text-white transition-all duration-200 hover:-translate-y-0.5" 
                        title="Copy link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

                    <!-- Delivery Info -->
                    <div class="space-y-3 pt-6 border-t">
                        <div class="flex hidden items-start gap-3">
                            <svg class="w-5 h-5 text-gray-700 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Estimated Delivery:</p>
                                <p class="text-gray-600">{{ now()->addDays(7)->format('F d') }} -
                                    {{ now()->addDays(14)->format('F d') }}</p>
                            </div>
                        </div>
                        @if($product->quantity > 0)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-700 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Quality Guaranteed:</p>
                                    <p class="text-gray-600">Premium products, carefully selected</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Methods -->
                    <div class="pt-6 border-t text-center hidden">
                        <div class="flex items-center justify-center gap-4 mb-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa"
                                class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                alt="Mastercard" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
                                class="h-6">
                        </div>
                        <p class="text-sm text-gray-600">Guarantee safe & secure checkout</p>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="mt-10 border-t pt-8">
                <div class="flex gap-8 mb-8 border-b">
                    <button type="button" onclick="showTab('description')"
                        class="tab-btn font-semibold text-gray-900 border-b-2 border-gray-900 pb-3 -mb-px"
                        data-tab="description">
                        Description
                    </button>
                    <button type="button" onclick="showTab('ingredients')"
                        class="tab-btn font-semibold text-gray-500 hover:text-gray-900 pb-3" data-tab="ingredients">
                        Ingredients
                    </button>
                    <button type="button" onclick="showTab('reviews')"
                        class="tab-btn font-semibold text-gray-500 hover:text-gray-900 pb-3" data-tab="reviews">
                        Reviews ({{ $product->reviews_count }})
                    </button>
                </div>

                <!-- Tab Contents -->
                <div id="description-tab" class="tab-content prose max-w-none">
                    {!! $product->description !!}
                </div>

                <div id="ingredients-tab" class="tab-content hidden prose max-w-none">
                    {!! $product->ingredients !!}
                </div>

                <div id="reviews-tab" class="tab-content hidden">
                <div
                    class="mb-6 flex flex-col sm:flex-row bg-white/80 justify-between p-4 sm:p-6 rounded-xl items-start sm:items-center gap-4 sm:gap-0 border border-gray-200">
                    <p class="text-gray-700 mb-2 sm:mb-0 font-bold text-sm sm:text-base">
                        Got thoughts on this product?
                    </p>
                    <button id="show-review-form-btn"
                        class="bg-[#ef380d] hover:bg-[#d6320c] text-white px-4 py-2 sm:px-6 sm:py-2 rounded-full font-medium flex items-center gap-2 text-sm sm:text-base transition-all duration-200 hover:shadow-lg">
                        Leave A Review
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="pt-6">
                    <h2 class="text-xl font-bold mb-8 text-gray-900">Reviews ({{ $product->review_count }})</h2>

                    @if($product->review_count > 0)

                        {{-- 🆕 SORTING DROPDOWN --}}
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium text-gray-700">Sort by:</label>
                                <select id="sortReviews"
                                    class="border border-gray-300 rounded-full px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] transition-all duration-200">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="highest">Highest Rating</option>
                                    <option value="lowest">Lowest Rating</option>
                                    <option value="helpful">Most Helpful</option>
                                </select>
                            </div>
                        </div>

                        {{-- 🆕 RATING SUMMARY --}}
                        <div class="bg-white p-6 rounded-xl mb-8 border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-center">
                                    <h3 class="text-4xl font-bold text-[#ef380d]">
                                        {{ number_format($product->average_rating, 1) }}
                                    </h3>
                                    <div class="flex text-yellow-400 text-2xl mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $product->average_rating ? '' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">{{ $product->review_count }} Reviews</p>
                                </div>
                            </div>
                        </div>

                        <div id="reviews-list">
                            {{-- REAL REVIEWS LOADED BY JS --}}
                        </div>

                        <div
                            class="flex flex-col sm:flex-row justify-start items-center space-y-4 sm:space-y-0 sm:space-x-2 mt-8">
                            <button id="prevPage"
                                class="pagination-button text-[#ef380d] font-bold px-3 py-1 rounded-full border border-transparent hover:border-[#ef380d] hover:bg-[#ef380d]/5 transition duration-300 flex items-center space-x-1 text-sm sm:text-base">
                                <svg width="8" height="13" viewBox="0 0 8 13" fill="none">
                                    <path d="m7.41 11.572-4.58-4.59 4.58-4.59L6 .982l-6 6 6 6z" fill="#ef380d"></path>
                                </svg>
                                <span class="ml-2 sm:ml-3">Previous</span>
                            </button>
                            <div id="pagination-numbers" class="flex space-x-2 text-gray-600"></div>
                            <button id="nextPage"
                                class="pagination-button text-[#ef380d] font-bold px-3 py-1 rounded-full border border-transparent hover:border-[#ef380d] hover:bg-[#ef380d]/5 transition duration-300 flex items-center space-x-1 text-sm sm:text-base">
                                <span class="mr-2 sm:mr-3">Next</span>
                                <svg width="9" height="13" viewBox="0 0 9 13" fill="none">
                                    <path d="m.824 2.392 4.58 4.59-4.58 4.59 1.41 1.41 6-6-6-6z" fill="#ef380d"></path>
                                </svg>
                            </button>
                        </div>

                    @else
                        <div class="text-center py-12 px-6 bg-gray-50 border border-dashed border-gray-300 rounded-xl">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M11.05 18.25l-.46.46a.75.75 0 01-1.06 0l-1.08-1.08a.75.75 0 010-1.06l4.5-4.5a.75.75 0 011.06 0l1.08 1.08a.75.75 0 010 1.06l-4.5 4.5zM12 11.25a.75.75 0 10-1.5 0 .75.75 0 001.5 0zM12 21a9 9 0 100-18 9 9 0 000 18z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">No Reviews Yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Be the first to share your thoughts on this product.</p>
                            <div class="mt-6">
                                <button id="show-review-form-empty-btn"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-[#ef380d] hover:bg-[#d6320c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ef380d] transition-all duration-200">
                                    Leave a Review
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- The Review Form - Hidden by default --}}
                    <div class="mt-10 hidden" id="review-form-container">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">Write Your Review</h2>
                                <button id="close-review-form"
                                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif

                            <form id="review-form" action="{{ route('product.review.store', $product->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <!-- Rating Field -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Your Rating <span
                                            class="text-red-500">*</span></label>
                                    <div class="flex items-center text-3xl space-x-1 text-gray-300 review-stars"
                                        id="rating-stars">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden"
                                                {{ old('rating') == $i ? 'checked' : '' }}>
                                            <label for="star{{ $i }}"
                                                class="cursor-pointer transition-colors duration-200 hover:text-yellow-500">★</label>
                                        @endfor
                                    </div>
                                    <div id="rating-error" class="text-red-500 text-sm mt-1 hidden">Please select a rating
                                    </div>
                                    @error('rating')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Name & Email -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', auth()->user()->name ?? '') }}" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-[#ef380d] focus:ring-2 focus:ring-[#ef380d]/20 transition duration-200">
                                        <div id="name-error" class="text-red-500 text-sm mt-1 hidden">Please enter your name
                                        </div>
                                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email
                                            (Optional)</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', auth()->user()->email ?? '') }}"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-[#ef380d] focus:ring-2 focus:ring-[#ef380d]/20 transition duration-200">
                                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <!-- Review Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Review Title
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-[#ef380d] focus:ring-2 focus:ring-[#ef380d]/20 transition duration-200">
                                    <div id="title-error" class="text-red-500 text-sm mt-1 hidden">Please enter a review
                                        title</div>
                                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- Review Content -->
                                <div>
                                    <label for="review" class="block text-sm font-semibold text-gray-700 mb-2">Your Review
                                        <span class="text-red-500">*</span></label>
                                    <textarea id="review" name="review" rows="4" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-[#ef380d] focus:ring-2 focus:ring-[#ef380d]/20 transition duration-200">{{ old('review') }}</textarea>
                                    <div id="review-error" class="text-red-500 text-sm mt-1 hidden">Please write your review
                                    </div>
                                    @error('review')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- Image Upload -->
                                <div>
                                    <label for="image_file" class="block text-sm font-semibold text-gray-700 mb-2">Upload
                                        Image (Optional)</label>
                                    <input type="file" id="image_file" name="image_file"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#ef380d]/10 file:text-[#ef380d] hover:file:bg-[#ef380d]/20">
                                    @error('image_file')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex gap-3">
                                    <button type="submit" id="submit-review-btn"
                                        class="bg-[#ef380d] hover:bg-[#d6320c] text-white font-semibold py-3 px-8 rounded-xl transition-colors duration-300 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed">
                                        Submit Review
                                    </button>
                                    <button type="button" id="cancel-review-form"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-colors duration-300">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            {{-- Related products --}}
    @if($relatedProducts && $relatedProducts->count())
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-6">Related Products</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $product)
                    <div class="gsp-search-recommend-collection-item group">
                        <div class="card overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 gsp-product-card" style="background: linear-gradient(145deg, #fffaf8, #ffe8e3);">
                            <!-- Image Section -->
                            <figure class="gsp-product-card-image relative overflow-hidden mb-0"
                                style="--aspect-ratio: 1/1;">
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
                                        data-product-price="{{ $product->price }}"
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
                                        class="hidden bg-white hover:bg-red-500 text-gray-900 hover:text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
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
                                <div class="gsp-product-price gsp-product-card-price flex items-center text-sm mb-2 {{ $product->compare_at_price ? 'gsp-price-on-sale' : '' }}">
                                    @if ($product->compare_at_price)
                                        <div class="gsp-product__price-sale">
                                            <span class="gsp-price-item-regular line-through text-stone-500 mr-2">
                                                {{ number_format($product->compare_at_price, 2) }} {{ app_currency() }}
                                            </span>
                                            <span class="gsp-price-item-sale font-semibold text-rose-500">
                                                {{ number_format($product->price, 2) }} {{ app_currency() }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="gsp-product__price-regular">
                                            <span class="gsp-price-item-regular font-semibold text-stone-700">
                                                {{ number_format($product->price, 2) }} {{ app_currency() }}
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
                                        data-product-price="{{ $product->price }}"
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
                @endforeach
            </div>
        </div>
    @endif
        </div>
    </section>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const reviewFormContainer = document.getElementById('review-form-container');
                    const showReviewFormBtn = document.getElementById('show-review-form-btn');
                    const showReviewFormEmptyBtn = document.getElementById('show-review-form-empty-btn');
                    const closeReviewFormBtn = document.getElementById('close-review-form');
                    const cancelReviewFormBtn = document.getElementById('cancel-review-form');
                    const reviewForm = document.getElementById('review-form');
                    const submitReviewBtn = document.getElementById('submit-review-btn');

                    // Form elements for validation
                    const ratingInputs = document.querySelectorAll('input[name="rating"]');
                    const nameInput = document.getElementById('name');
                    const titleInput = document.getElementById('title');
                    const reviewTextarea = document.getElementById('review');

                    // Error elements
                    const ratingError = document.getElementById('rating-error');
                    const nameError = document.getElementById('name-error');
                    const titleError = document.getElementById('title-error');
                    const reviewError = document.getElementById('review-error');

                    // Show review form
                    function showReviewForm() {
                        reviewFormContainer.classList.remove('hidden');
                        reviewFormContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    // Hide review form
                    function hideReviewForm() {
                        reviewFormContainer.classList.add('hidden');
                        clearErrors();
                        resetForm();
                    }

                    // Clear all error messages
                    function clearErrors() {
                        ratingError.classList.add('hidden');
                        nameError.classList.add('hidden');
                        titleError.classList.add('hidden');
                        reviewError.classList.add('hidden');

                        // Remove error borders
                        nameInput.classList.remove('border-red-500');
                        titleInput.classList.remove('border-red-500');
                        reviewTextarea.classList.remove('border-red-500');
                    }

                    // Reset form to initial state
                    function resetForm() {
                        reviewForm.reset();
                        highlightStars(0);
                        updateSubmitButton();
                    }

                    // Validate form
                    function validateForm() {
                        let isValid = true;
                        clearErrors();

                        // Check rating
                        const ratingSelected = document.querySelector('input[name="rating"]:checked');
                        if (!ratingSelected) {
                            ratingError.classList.remove('hidden');
                            isValid = false;
                        }

                        // Check name
                        if (!nameInput.value.trim()) {
                            nameError.classList.remove('hidden');
                            nameInput.classList.add('border-red-500');
                            isValid = false;
                        }

                        // Check title
                        if (!titleInput.value.trim()) {
                            titleError.classList.remove('hidden');
                            titleInput.classList.add('border-red-500');
                            isValid = false;
                        }

                        // Check review content
                        if (!reviewTextarea.value.trim()) {
                            reviewError.classList.remove('hidden');
                            reviewTextarea.classList.add('border-red-500');
                            isValid = false;
                        }

                        return isValid;
                    }

                    // Update submit button state
                    function updateSubmitButton() {
                        const ratingSelected = document.querySelector('input[name="rating"]:checked');
                        const nameFilled = nameInput.value.trim();
                        const titleFilled = titleInput.value.trim();
                        const reviewFilled = reviewTextarea.value.trim();

                        submitReviewBtn.disabled = !(ratingSelected && nameFilled && titleFilled && reviewFilled);
                    }

                    // Star rating functionality
                    function highlightStars(count) {
                        const stars = document.querySelectorAll('#rating-stars label');
                        stars.forEach((star, index) => {
                            if (5 - index <= count) {
                                star.classList.add('text-yellow-400');
                                star.classList.remove('text-gray-300', 'text-yellow-500');
                            } else {
                                star.classList.remove('text-yellow-400', 'text-yellow-500');
                                star.classList.add('text-gray-300');
                            }
                        });
                        updateSubmitButton();
                    }

                    // Event Listeners
                    showReviewFormBtn?.addEventListener('click', showReviewForm);
                    showReviewFormEmptyBtn?.addEventListener('click', showReviewForm);
                    closeReviewFormBtn?.addEventListener('click', hideReviewForm);
                    cancelReviewFormBtn?.addEventListener('click', hideReviewForm);

                    // Star rating interactions
                    document.querySelectorAll('#rating-stars label').forEach(star => {
                        star.addEventListener('click', (e) => {
                            const rating = e.target.htmlFor.replace('star', '');
                            highlightStars(parseInt(rating));
                        });

                        star.addEventListener('mouseover', (e) => {
                            const rating = e.target.htmlFor.replace('star', '');
                            const stars = document.querySelectorAll('#rating-stars label');
                            stars.forEach((s, index) => {
                                if (5 - index <= rating) {
                                    s.classList.add('text-yellow-500');
                                    s.classList.remove('text-gray-300');
                                }
                            });
                        });

                        star.addEventListener('mouseout', () => {
                            const checkedInput = document.querySelector('#rating-stars input:checked');
                            highlightStars(checkedInput ? parseInt(checkedInput.value) : 0);
                        });
                    });

                    // Input validation on change
                    nameInput.addEventListener('input', updateSubmitButton);
                    titleInput.addEventListener('input', updateSubmitButton);
                    reviewTextarea.addEventListener('input', updateSubmitButton);

                    // Remove error styling when user starts typing
                    nameInput.addEventListener('input', () => {
                        nameError.classList.add('hidden');
                        nameInput.classList.remove('border-red-500');
                    });

                    titleInput.addEventListener('input', () => {
                        titleError.classList.add('hidden');
                        titleInput.classList.remove('border-red-500');
                    });

                    reviewTextarea.addEventListener('input', () => {
                        reviewError.classList.add('hidden');
                        reviewTextarea.classList.remove('border-red-500');
                    });

                    // Form submission
                    reviewForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        if (validateForm()) {
                            // If form is valid, submit it
                            this.submit();
                        } else {
                            // Scroll to first error
                            const firstError = document.querySelector('.text-red-500:not(.hidden)');
                            if (firstError) {
                                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    });

                    // Initialize
                    highlightStars(0);
                });
            </script>

            @push('styles')
                <style>
                    /* 🆕 Review Sorting */
                    #sortReviews {
                        background: white;
                        min-width: 140px;
                    }

                    .pagination-button.active {
                        background: #ef380d !important;
                        color: white !important;
                    }

                    .review-transition {
                        transition: all 0.3s ease;
                    }

                    /* Active tab styling */
                    .tab-button.active {
                        background: #ef380d !important;
                        color: white !important;
                        border-color: #ef380d !important;
                    }

                    .tab-button:hover:not(.active) {
                        background: #ef380d/5 !important;
                        color: #ef380d !important;
                    }

                    /* Share Dropdown Styles */
                    .share-dropdown {
                        position: relative;
                    }

                    .share-menu {
                        position: absolute;
                        top: calc(100% + 0.5rem);
                        left: 0;
                        background: white;
                        border: 1px solid #e5e7eb;
                        border-radius: 1rem;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
                        opacity: 0;
                        visibility: hidden;
                        transform: translateY(-10px) scale(0.95);
                        transition: all 0.2s ease;
                        z-index: 50;
                        padding: 0.5rem;
                    }

                    .share-menu.active {
                        opacity: 1;
                        visibility: visible;
                        transform: translateY(0) scale(1);
                    }

                    .share-menu-title {
                        padding: 0.5rem 0.75rem;
                        font-size: 0.875rem;
                        font-weight: 600;
                        color: #1f2937;
                        text-align: center;
                        margin-bottom: 0.25rem;
                    }

                    .share-options-grid {
                        display: flex;
                        gap: 0.5rem;
                        padding: 0.25rem;
                    }

                    .share-option-horizontal {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 2.5rem;
                        height: 2.5rem;
                        color: #1f2937;
                        text-decoration: none;
                        transition: all 0.15s ease;
                        cursor: pointer;
                        border: none;
                        background: none;
                        border-radius: 0.5rem;
                    }

                    .share-option-horizontal:hover {
                        background: rgba(239, 56, 13, 0.1);
                        transform: scale(1.1);
                    }

                    .share-icon-horizontal {
                        width: 1.5rem;
                        height: 1.5rem;
                    }
                </style>
            @endpush
    <script>
        // Image Gallery
        function changeMainImage(imageSrc) {
            document.getElementById('main-product-image').src = imageSrc;

            // Update thumbnail borders
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-gray-900');
                btn.classList.add('border-gray-200');
            });
            event.currentTarget.classList.remove('border-gray-200');
            event.currentTarget.classList.add('border-gray-900');
        }

        // Size Selection
        let selectedSizeId = {{ $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0 }};
        
        function selectSize(sizeId, sizeName, originalPrice, discountedPrice) {
            selectedSizeId = sizeId;
            
            // Update selected size display
            document.getElementById('selected-size-display').textContent = sizeName;
            
            // Update pricing display
            const displayPriceEl = document.getElementById('display-price');
            const originalPriceEl = document.getElementById('original-price-display');
            const saleBadge = document.getElementById('sale-badge');
            
            // Format prices
            const originalPriceFormatted = originalPrice.toFixed(2);
            const discountedPriceFormatted = discountedPrice.toFixed(2);
            
            // Check if discount applies
            const hasDiscount = originalPrice !== discountedPrice;
            
            if (hasDiscount) {
                // Show original price (slashed) and discounted price
                originalPriceEl.textContent = currency + ' ' + originalPriceFormatted;
                originalPriceEl.classList.remove('hidden');
                displayPriceEl.textContent = currency + ' ' + discountedPriceFormatted;
                
                // Show sale badge
                if (saleBadge) {
                    saleBadge.classList.remove('hidden');
                }
            } else {
                // Only show original price
                displayPriceEl.textContent = currency + ' ' + originalPriceFormatted;
                originalPriceEl.classList.add('hidden');
                
                // Hide sale badge
                if (saleBadge) {
                    saleBadge.classList.add('hidden');
                }
            }

            // Update size buttons
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('border-gray-900', 'bg-gray-900', 'text-white');
                btn.classList.add('border-gray-300');
            });
            
            // Find and update the clicked button
            const clickedButton = document.querySelector(`[data-size-id="${sizeId}"]`);
            if (clickedButton) {
                clickedButton.classList.remove('border-gray-300');
                clickedButton.classList.add('border-gray-900', 'bg-gray-900', 'text-white');
            }

            // Update cart button data - use discounted price for cart
            const cartButton = document.querySelector('.cart-item-btn');
            if (cartButton) {
                cartButton.dataset.sizeId = sizeId;
                cartButton.dataset.productPrice = discountedPriceFormatted;
            }

            // Update buy now link
            const quantity = document.getElementById('quantity').value;
            const buyNowLink = document.getElementById('buy-now-link');
            if (buyNowLink) {
                buyNowLink.href = checkoutRoute.replace('/1/', `/${quantity}/`).replace(/\/\d+$/, `/${sizeId}`);
            }
        }
        
        // Initialize pricing on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Get first size data or use product data
            @if($product->sizes->isNotEmpty())
                const firstSize = productSizes[0];
                if (firstSize) {
                    // Update pricing display for initial size
                    const displayPriceEl = document.getElementById('display-price');
                    const originalPriceEl = document.getElementById('original-price-display');
                    const saleBadge = document.getElementById('sale-badge');
                    
                    if (firstSize.hasDiscount) {
                        originalPriceEl.textContent = currency + ' ' + firstSize.originalPrice.toFixed(2);
                        originalPriceEl.classList.remove('hidden');
                        displayPriceEl.textContent = currency + ' ' + firstSize.discountedPrice.toFixed(2);
                        if (saleBadge) saleBadge.classList.remove('hidden');
                    } else {
                        displayPriceEl.textContent = currency + ' ' + firstSize.originalPrice.toFixed(2);
                        originalPriceEl.classList.add('hidden');
                        if (saleBadge) saleBadge.classList.add('hidden');
                    }
                    
                    // Update cart button with discounted price
                    const cartButton = document.querySelector('.cart-item-btn');
                    if (cartButton) {
                        cartButton.dataset.productPrice = firstSize.discountedPrice.toFixed(2);
                    }
                }
            @endif
        });

        // Quantity Controls
        document.getElementById('decrement').addEventListener('click', () => {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateBuyNowLink();
            }
        });

        document.getElementById('increment').addEventListener('click', () => {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
            updateBuyNowLink();
        });

        function updateBuyNowLink() {
            const quantity = document.getElementById('quantity').value;
            const buyNowLink = document.getElementById('buy-now-link');
            buyNowLink.href = checkoutRoute.replace('/1/', `/${quantity}/`).replace(/\/\d+$/, `/${selectedSizeId}`);
        }

        // Tabs
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-gray-900', 'text-gray-900');
                btn.classList.add('text-gray-500', 'border-transparent');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            // Add active state to clicked button
            const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
            activeBtn.classList.remove('text-gray-500', 'border-transparent');
            activeBtn.classList.add('text-gray-900', 'border-gray-900');
        }

        // Share Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function () {
            const shareToggle = document.getElementById('share-toggle');

            if (shareToggle) {
                const shareMenu = shareToggle.nextElementSibling;

                shareToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isActive = shareMenu.classList.contains('active');

                    // Close all share menus
                    document.querySelectorAll('.share-menu').forEach(menu => {
                        menu.classList.remove('active');
                        menu.classList.add('hidden');
                    });

                    // Toggle current menu
                    if (!isActive) {
                        shareMenu.classList.add('active');
                        shareMenu.classList.remove('hidden');
                    } else {
                        shareMenu.classList.remove('active');
                        shareMenu.classList.add('hidden');
                    }
                });

                // Close on outside click
                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.share-dropdown')) {
                        document.querySelectorAll('.share-menu').forEach(menu => {
                            menu.classList.remove('active');
                            menu.classList.add('hidden');
                        });
                    }
                });
            }
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
                menu.classList.add('hidden');
            });
        }
        
        function copyProductLink(url) {
            console.log(url);
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
                        menu.classList.add('hidden');
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
                    menu.classList.add('hidden');
                });
            });
        }
    </script>

    <script src="{{ asset('js/productDetail.js') }}"></script>
@endsection