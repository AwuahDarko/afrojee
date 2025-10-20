<!-- <script>
    const appCurrency = @json(app_currency());

    const checkoutRoute = {!! json_encode(
        route('web.checkoutDetails.single', [
            'product_id' => $product->id,
            'quantity' => 1,
            'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0,
        ])
    ) !!};
</script> -->
@php
    $checkoutUrl = route('web.checkoutDetails.single', [
        'product_id' => $product->id,
        'quantity' => 1,
        'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0,
    ]);
@endphp
<script>
    const checkoutRoute = @json($checkoutUrl);

    const productReviews = @json($product->reviews);

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
    <section class="bg-[#f7f3e9] py-8 px-4 md:py-16 md:px-8 text-gray-800">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 md:gap-10 items-start px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="flex flex-col justify-center w-full max-w-md mx-auto"> <!-- Added max-w-md and mx-auto -->
                {{-- Product Image Gallery --}}
                @if($product->images->isNotEmpty())
                    @php
                        $primary = $product->getPrimaryImage() ?? $product->images->first();
                        $initialImage = $primary->image_path ? $primary->image_path : $product->image ?? asset('images/default-product.png');
                    @endphp

                    {{-- Main Image Display --}}
                    <div class="relative w-full">
                        {{-- Mobile Version with Blur Background --}}
                        <div class="relative sm:hidden w-full h-48 overflow-hidden rounded-xl shadow-lg">
                            <!-- Reduced h-64 to h-48 -->
                            <img id="blur-bg-mobile" src="{{ $initialImage }}" alt=""
                                class="absolute inset-0 w-full h-full object-cover blur-lg scale-110" aria-hidden="true" />
                            <div class="absolute inset-0 flex items-center justify-center p-4">
                                <img id="main-img-mobile" src="{{ $initialImage }}" alt="{{ $product->name }}"
                                    class="max-w-full max-h-40 object-contain rounded-lg shadow-lg" /> <!-- Added max-h-40 -->
                            </div>
                        </div>

                        {{-- Desktop Version --}}
                        <div class="hidden sm:block w-full max-w-xs mx-auto"> <!-- Added wrapper with max-w-xs -->
                            <img id="main-img-desktop" src="{{ $initialImage }}" alt="{{ $product->name }}"
                                class="rounded-xl w-full h-64 object-cover shadow-lg" /> <!-- Added fixed h-64 -->
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    <div class="flex gap-2 mt-4 overflow-x-auto pb-2 thumbnails-container justify-center">
                        <!-- Added justify-center -->
                        @foreach($product->images as $image)
                            <img src="{{ $image->image_path }}" alt="{{ $product->name }} thumbnail"
                                class="thumbnail w-16 h-16 object-cover rounded-md cursor-pointer border-2 transition-all {{ $image->is_primary || ($loop->first && !$product->getPrimaryImage()) ? 'border-pink-800 opacity-100' : 'border-gray-300 opacity-75 hover:opacity-100' }}"
                                data-src="{{ $image->image_path }}">
                        @endforeach
                    </div>
                @else
                    {{-- Fallback if no images --}}
                    <div class="w-full max-w-xs mx-auto"> <!-- Added wrapper -->
                        <img src="{{ asset('images/default-product.png') }}" alt="{{ $product->name }}"
                            class="rounded-xl w-full h-64 object-cover shadow-lg" /> <!-- Added fixed h-64 -->
                    </div>
                @endif
            </div>

            <div class="text-center md:text-left">
                <!-- Product Name -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 text-gray-900 leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Ratings -->
                @if(($product->reviews_count ?? 0) > 0)
                    <div class="flex items-center justify-center md:justify-start mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                @for($i = 1; $i <= 5; $i++) <svg
                                        class="w-5 h-5 sm:w-6 sm:h-6 {{ $i <= floor($product->average_rating) ? 'fill-current' : 'fill-gray-300' }}"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-gray-600 text-sm sm:text-base font-medium ml-2">
                                {{ number_format($product->average_rating, 1) }} • {{ $product->reviews_count ?? 0 }} reviews
                            </span>
                        </div>
                    </div>
                @endif
                <!-- Price -->
                <div class="mb-5 sm:mb-6">
                    <p class="text-3xl sm:text-4xl font-bold text-gray-900 text-left" id="price-display">
                        @if ($product->getPrice() != $product->getOriginalPrice())
                                            <span class="text-[#ef380d] mr-3" id="current-price">
                                                {{ app_currency() }} &nbsp;{{ number_format($product->getPrice(), 2) }}
                                            </span>
                                            <span class="text-gray-500 line-through text-xl sm:text-2xl" id="original-price">
                                                {{ app_currency() }} &nbsp;{{ number_format($product->getOriginalPrice(), 2) }}
                                            </span>
                                            <span class="ml-3 bg-[#ef380d]/10 text-[#ef380d] text-sm font-semibold px-3 py-1 rounded-full">
                                                Save {{ app_currency() }} &nbsp;{{ number_format(
                                $product->getOriginalPrice() - $product->getPrice(),
                                2
                            ) }}
                                            </span>
                        @else
                            <span id="current-price">{{ app_currency() }}
                                &nbsp;{{ number_format($product->getPrice(), 2) }}</span>
                        @endif
                    </p>
                </div>
                <!-- Size Selector -->
                <div class="mb-6 @if($product->sizes->isEmpty()) hidden @endif">

                    <div class="flex items-center gap-4">

                        <label for="size" class="text-sm font-semibold text-gray-700 flex-shrink-0">Select Size:</label>

                        <div class="relative inline-block w-full max-w-xs flex-grow">
                            <select id="size" name="size"
                                class="appearance-none w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 text-gray-700 focus:outline-none focus:border-[#ef380d] focus:ring-2 focus:ring-[#ef380d]/20 transition-all duration-200 cursor-pointer shadow-sm">
                                @if ($product->sizes->isNotEmpty())
                                    @foreach ($product->sizes as $size)
                                        <option value="{{ $size->id }}" data-price="{{ $size->price }}"
                                            data-quantity="{{ $size->quantity }}" {{ $loop->first ? 'selected' : '' }}>
                                            {{ $size->size }} - {{ app_currency() }}{{ number_format($size->price, 2) }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="0" data-price="{{ $product->price }}"
                                        data-quantity="{{ $product->quantity }}" selected>
                                        One Size - {{ app_currency() }}{{ number_format($product->price, 2) }}
                                    </option>
                                @endif
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    @error('size')
                        <div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Description -->
                <div class="mb-6 sm:mb-8 hidden">
                    <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                        {!! Str::limit($product->description, 200) !!}
                    </p>
                    @if(strlen($product->description) > 200)
                        <button
                            class="text-[#ef380d] font-semibold text-sm mt-2 hover:text-[#d6320c] transition-colors duration-200">
                            Read more
                        </button>
                    @endif
                </div>

                <!-- Quantity & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 mb-6 sm:mb-8">
            
            <!-- Quantity Selector -->
            <div class="flex items-center justify-start">
                <span class="text-sm font-semibold text-gray-700 mr-4">Quantity:</span>
                <div class="flex items-center space-x-1 border-2 border-gray-200 rounded-2xl px-3 py-2 bg-white shadow-sm">
                    <button id="decrement"
                        class="text-xl font-bold text-gray-500 rounded-full p-1 w-8 h-8 flex items-center justify-center hover:bg-gray-50 hover:text-gray-700 active:bg-gray-100 transition-all duration-200">
                        −
                    </button>
                    <input type="text" id="quantity" value="1" autocomplete="off"
                        class="w-12 text-center focus:outline-none bg-transparent text-lg font-bold text-gray-900"
                        readonly />
                    <button id="increment"
                        class="text-xl font-bold text-gray-500 rounded-full p-1 w-8 h-8 flex items-center justify-center hover:bg-gray-50 hover:text-gray-700 active:bg-gray-100 transition-all duration-200">
                        +
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 w-full sm:w-auto">
                
                <!-- Buy Now Button -->
                <a href="#" class="flex-grow sm:flex-grow-0" id="buy-now-link">
                    <button class="relative bg-gradient-to-r from-[#ef380d] to-[#d6320c] hover:from-[#d6320c] hover:to-[#bf2c0a] text-white px-8 py-4 rounded-2xl font-semibold flex items-center justify-center gap-3 text-base w-full transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105 active:scale-95 shadow-md">
                        <span id="buyNowCounter"
                            class="absolute -left-2 -top-2 text-xs bg-white text-[#ef380d] border-2 border-[#ef380d] rounded-full px-2 py-1 font-bold shadow-sm">
                            1
                        </span>
                        Buy Now
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>

                <!-- Add to Cart Button -->
                <button data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->price : $product->price }}"
                        data-product-image="{{ $product->getPrimaryImage()?->image_path ? $product->getPrimaryImage()?->image_path : $product->image ?? asset('images/default-product.png') }}"
                        data-size-id="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->id : null }}"
                    class="cart-item-btn relative bg-white border-2 border-[#ef380d] p-3 rounded-2xl text-[#ef380d] hover:bg-[#ef380d]/5 w-14 h-14 flex items-center justify-center transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105 active:scale-95 shadow-sm flex-shrink-0">
                    <svg width="22" height="22" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#a)" fill="#ef380d">
                            <path d="M21.377 22.5a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.113-2.5 2.5-2.5m-20-20h4.087L6.64 5h18.488a1.25 1.25 0 0 1 1.25 1.25c0 .213-.062.425-.15.625l-4.475 8.088a2.51 2.51 0 0 1-2.187 1.287h-9.313l-1.125 2.038-.038.15a.313.313 0 0 0 .313.312h14.475v2.5h-15a2.5 2.5 0 0 1-2.5-2.5c0-.437.112-.85.3-1.2l1.7-3.062L3.877 5h-2.5zm7.5 20a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.112-2.5 2.5-2.5m11.25-8.75 3.475-6.25h-15.8l2.95 6.25z" />
                            <path d="M25.127 15.5v6h6v4h-6v6h-4v-6h-6v-4h6v-6z" stroke="white" stroke-width="2" />
                        </g>
                        <defs>
                            <clipPath id="a">
                                <path fill="#fff" d="M.127 0h30v30h-30z" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span id="addToCartCounter"
                        class="absolute -left-1 -top-1 text-xs bg-[#ef380d] text-white rounded-full px-2 py-1 font-bold shadow-sm">
                        1
                    </span>
                </button>
                
            </div>
        </div>

                <!-- Additional Info -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            @if($product->quantity > 0)
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-green-600">In stock</span>
                            @else
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-red-600">Out of stock</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Shipping Available
                        </div>
                        <!-- <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                30-day returns
                            </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-8 md:mt-12">
            <!-- Tabs Navigation -->
            <div class="flex flex-wrap gap-2 sm:gap-4 mt-4 mb-6">
                <button
                    class="tab-button border border-[#ef380d] px-3 py-1 sm:px-4 sm:py-2 rounded-full text-[#ef380d] font-medium active text-sm sm:text-base bg-[#ef380d]/10"
                    data-tab="description">
                    Description
                </button>
                <button
                    class="tab-button border border-[#ef380d] px-3 py-1 sm:px-4 sm:py-2 rounded-full text-[#ef380d] hover:bg-[#ef380d]/5 text-sm sm:text-base transition-colors duration-200"
                    data-tab="ingredients">
                    Ingredients
                </button>
                <button
                    class="tab-button border border-[#ef380d] px-3 py-1 sm:px-4 sm:py-2 rounded-full text-[#ef380d] hover:bg-[#ef380d]/5 text-sm sm:text-base transition-colors duration-200"
                    data-tab="how-to-use">
                    How To Use
                </button>
                <button
                    class="tab-button border border-[#ef380d] px-3 py-1 sm:px-4 sm:py-2 rounded-full text-[#ef380d] hover:bg-[#ef380d]/5 text-sm sm:text-base transition-colors duration-200"
                    data-tab="reviews">
                    Reviews
                </button>
            </div>

            <!-- Description Tab -->
            <div id="description-content" class="tab-content">
                <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-900">Product Description</h2>
                <div class="text-gray-700 leading-relaxed mb-6 prose max-w-none">
                    {!! $product->description !!}
                </div>

                {{-- 🆕 REAL TOP FEATURED REVIEWS --}}
                @if($product->reviews->where('is_featured', 1)->count() > 0)
                    <div class="container mx-auto px-0 py-8 sm:py-12">
                        <div class="mb-10 sm:mb-16">
                            <div class="flex flex-col md:flex-row items-center">
                                <h1 class="text-3xl sm:text-5xl min-w-[26%] font-medium text-[#ef380d]">
                                    <span class="block">Product</span>
                                    <span class="text-[#ef380d] font-bold text-3xl sm:text-5xl w-full">Top Reviews</span>
                                </h1>
                                <div class="w-full h-1 bg-[#ef380d]/30 mt-4 md:mt-0"></div>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-6">
                            <div class="lg:w-3/4 relative">
                                <div class="testimonial-container relative">
                                    @foreach($product->reviews->where('is_featured', 1)->take(4) as $index => $review)
                                        <div class="testimonial-slide {{ $loop->first ? 'active' : '' }}" data-index="{{ $index }}">
                                            <div
                                                class="bg-white p-6 sm:p-8 rounded-lg shadow-sm border border-gray-100 mb-6 sm:mb-8">
                                                <p class="text-base sm:text-lg text-gray-800 mb-4">"{{ $review->review }}"</p>
                                                <div class="flex items-center mt-6">
                                                    <div
                                                        class="w-10 h-10 sm:w-12 sm:h-12 bg-[#ef380d]/10 rounded-full overflow-hidden border-2 border-[#ef380d]">
                                                        <div
                                                            class="w-full h-full flex items-center justify-center bg-[#ef380d]/20 text-[#ef380d] font-bold text-sm">
                                                            {{ substr($review->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="flex text-yellow-400 mb-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                    </path>
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                        <p class="font-medium text-gray-700 text-sm sm:text-base">
                                                            {{ $review->name }}
                                                        </p>
                                                        <p class="text-xs sm:text-sm text-gray-500">
                                                            {{ $review->created_at->format('M Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex mt-4">
                                    <button id="prev-btn"
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-[#ef380d] text-white rounded-full shadow-md hover:bg-[#d6320c] transition-all duration-200">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button id="next-btn"
                                        class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-[#ef380d] text-white rounded-full shadow-md hover:bg-[#d6320c] transition-all duration-200 ml-4">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                    <div class="ml-auto flex items-center">
                                        <a href="#"
                                            class="text-[#ef380d] font-medium flex items-center hover:underline text-sm sm:text-base hover:text-[#d6320c] transition-colors duration-200"
                                            onclick="document.getElementById('reviews-tab').click(); return false;">
                                            View All Reviews
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:w-1/4 mt-8 lg:mt-1">
                                <div class="space-y-4 sm:space-y-6">
                                    @foreach($product->reviews->where('is_featured', 1)->take(4) as $index => $review)
                                        <div class="flex items-center cursor-pointer client-nav {{ $loop->first ? '' : 'opacity-50' }} transition-opacity duration-200 hover:opacity-100"
                                            data-index-client="{{ $index }}">
                                            <div
                                                class="client-nav-c w-8 h-8 sm:w-10 sm:h-10 bg-[#ef380d]/10 rounded-full overflow-hidden border-2 {{ $loop->first ? 'border-[#ef380d]' : 'border-gray-300' }} transition-all duration-200">
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-[#ef380d]/20 text-[#ef380d] font-bold text-xs">
                                                    {{ substr($review->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <p
                                                class="ml-4 font-medium {{ $loop->first ? 'text-gray-700' : 'text-gray-500' }} text-sm sm:text-base transition-colors duration-200">
                                                {{ $review->name }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Ingredients Tab -->
            <div id="ingredients-content" class="tab-content hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-900">Ingredients</h2>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    {!! $product->ingredients !!}
                </div>
            </div>

            <!-- How To Use Tab -->
            <div id="how-to-use-content" class="tab-content hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-900">How To Use</h2>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    {!! $product->how_to_use !!}
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-content" class="tab-content hidden">
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
                </style>
            @endpush
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImgDesktop = document.getElementById('main-img-desktop');
            const mainImgMobile = document.getElementById('main-img-mobile');
            const blurBgMobile = document.getElementById('blur-bg-mobile');

            function updateMainImage(src) {
                if (mainImgDesktop) mainImgDesktop.src = src;
                if (mainImgMobile) mainImgMobile.src = src;
                if (blurBgMobile) blurBgMobile.src = src;

                // Highlight active thumbnail
                thumbnails.forEach(thumb => {
                    thumb.classList.remove('border-pink-800', 'opacity-100');
                    thumb.classList.add('border-gray-300', 'opacity-75');
                    if (thumb.dataset.src === src) {
                        thumb.classList.remove('border-gray-300', 'opacity-75');
                        thumb.classList.add('border-pink-800', 'opacity-100');
                    }
                });
            }

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    updateMainImage(thumb.dataset.src);
                });
            });

            // Optional: Add keyboard navigation or swipe for mobile if needed
        });
    </script>
@endsection