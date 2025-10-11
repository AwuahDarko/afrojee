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
    const appCurrency = @json(app_currency());
    const checkoutRoute = @json($checkoutUrl);
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
    <meta property="og:image" content="{{ $product->image }}" />
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
            <div class="flex justify-center w-full">
                <div class="relative sm:hidden w-full h-64 overflow-hidden rounded-xl shadow-lg">
                    <img src="{{ $product->image }}" alt=""
                        class="absolute inset-0 w-full h-full object-cover blur-lg scale-110" aria-hidden="true" />
                    <div class="absolute inset-0 flex items-center justify-center p-4">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="max-w-full max-h-full object-contain rounded-lg shadow-lg" />
                    </div>
                </div>
                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                    class="hidden sm:block rounded-xl w-full max-w-sm md:max-w-md lg:max-w-full object-cover shadow-lg" />
            </div>

            <div class="text-center md:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2 sm:mb-3 text-gray-800">
                    {{ $product->name }}
                </h1>

                <div class="flex items-center justify-center md:justify-start text-yellow-400 mb-4">
                    <span>★★★★★</span>
                    <span class="ml-2 text-gray-600 text-sm">({{ number_format($product->reviews_avg_rating, 1) ?? '0.0' }} / 5)</span>
                </div>

                <div class="mb-4 @if($product->sizes->isEmpty()) hidden @endif">
                    <label for="size" class="font-bold text-base mr-2">Size</label>
                    <select id="size" name="size" class="border border-gray-300 rounded-full px-3 py-1 text-sm focus:outline-none">
                        @if ($product->sizes->isNotEmpty())
                            @foreach ($product->sizes as $size)
                                <option value="{{ $size->id }}"
                                    data-price="{{ $size->price }}"
                                    data-quantity="{{ $size->quantity }}"
                                    {{ $loop->first ? 'selected' : '' }}>
                                    {{ $size->size }} ({{ app_currency() }}{{ number_format($size->price, 2) }})
                                </option>
                            @endforeach
                        @else
                            <option value="0" data-price="{{ $product->price }}" data-quantity="{{ $product->quantity }}" selected>
                                Default ({{ app_currency() }}{{ number_format($product->price, 2) }})
                            </option>
                        @endif
                    </select>
                    @error('size')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <p class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4 sm:mb-6" id="price-display">
                    @if ($product->getPrice() != $product->getOriginalPrice())
                        <span class="text-red-600 mr-2" id="current-price">
                            {{ app_currency() }} {{ number_format($product->getPrice(), 2) }}
                        </span>
                        <span class="text-gray-500 line-through text-xl sm:text-2xl" id="original-price">
                            {{ app_currency() }} {{ number_format($product->getOriginalPrice(), 2) }}
                        </span>
                    @else
                        <span id="current-price">{{ app_currency() }} {{ number_format($product->getPrice(), 2) }}</span>
                    @endif
                </p>

                <p class="text-gray-700 mb-6 text-sm sm:text-base leading-relaxed">
                    {!! Str::limit($product->description, 200) !!}
                </p>

                <div class="flex flex-col sm:flex-row items-center sm:items-center gap-4 sm:gap-6 mb-6">
                    <div class="flex items-center justify-center sm:justify-start w-full sm:w-auto">
                        <span class="mr-2 font-bold text-base">Quantity</span>
                        <div class="flex items-center space-x-2 border border-gray-300 rounded-full px-1 py-0.5">
                            <button id="decrement"
                                class="text-lg font-bold text-gray-600 rounded-full p-1 w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition duration-300 ease-in-out">
                                −
                            </button>
                            <input type="text" id="quantity" value="1" autocomplete="off"
                                class="w-10 text-center focus:outline-none bg-transparent text-lg font-bold" readonly />
                            <button id="increment"
                                class="text-lg font-bold text-gray-600 rounded-full p-1 w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition duration-300 ease-in-out">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-center sm:justify-start gap-3 sm:gap-4 flex-wrap w-full sm:w-auto">
                        <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id, 'quantity' => 1, 'size_id' => $product->sizes->isNotEmpty() ? $product->sizes->first()->id : 0]) }}"
                            class="flex-grow sm:flex-grow-0 w-full sm:w-auto" id="buy-now-link">
                            <button
                                class="relative bg-pink-800 hover:bg-pink-900 text-white px-5 py-2 rounded-full font-medium flex items-center justify-center gap-2 text-base w-full transition-all duration-300 ease-in-out hover:scale-105">
                                <span id="buyNowCounter"
                                    class="absolute -left-2 -top-2 text-xs bg-white text-pink-800 border border-pink-800 rounded-full px-1.5 py-0.5 font-bold shadow">
                                    1
                                </span>
                                Buy Now
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </button>
                        </a>
                        <button data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->name }}"
                            data-product-price="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->price : $product->price }}"
                            data-product-image="{{ $product->image }}"
                            data-size-id="{{ $product->sizes->isNotEmpty() ? $product->sizes->first()->id : null }}"
                            class="cart-item-btn relative bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100 w-10 h-10 flex items-center justify-center transition-all duration-300 ease-in-out hover:scale-105">
                            <svg width="20" height="20" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#a)" fill="#99395C">
                                    <path
                                        d="M21.377 22.5a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.113-2.5 2.5-2.5m-20-20h4.087L6.64 5h18.488a1.25 1.25 0 0 1 1.25 1.25c0 .213-.062.425-.15.625l-4.475 8.088a2.51 2.51 0 0 1-2.187 1.287h-9.313l-1.125 2.038-.038.15a.313.313 0 0 0 .313.312h14.475v2.5h-15a2.5 2.5 0 0 1-2.5-2.5c0-.437.112-.85.3-1.2l1.7-3.062L3.877 5h-2.5zm7.5 20a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.112-2.5 2.5-2.5m11.25-8.75 3.475-6.25h-15.8l2.95 6.25z" />
                                    <path d="M25.127 15.5v6h6v4h-6v6h-4v-6h-6v-4h6v-6z" stroke="#FCF4F7" stroke-width="2" />
                                </g>
                                <defs>
                                    <clipPath id="a">
                                        <path fill="#fff" d="M.127 0h30v30h-30z" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span id="addToCartCounter"
                                class="absolute -left-1 -top-1 text-xs bg-pink-800 text-white rounded-full px-1.5 py-0.5 font-bold shadow">
                                1
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-8 md:mt-12">
            <div class="flex flex-wrap gap-2 sm:gap-4 mt-4 mb-6">
                <button
                    class="tab-button border border-pink-700 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-pink-800 font-medium active text-sm sm:text-base"
                    data-tab="description">
                    Description
                </button>
                <button
                    class="tab-button border border-pink-700 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-pink-800 hover:bg-pink-100 text-sm sm:text-base"
                    data-tab="ingredients">
                    Ingredients
                </button>
                <button
                    class="tab-button border border-pink-700 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-pink-800 hover:bg-pink-100 text-sm sm:text-base"
                    data-tab="how-to-use">
                    How To Use
                </button>
                <button
                    class="tab-button border border-pink-700 px-3 py-1 sm:px-4 sm:py-2 rounded-full text-pink-800 hover:bg-pink-100 text-sm sm:text-base"
                    data-tab="reviews">
                    Reviews
                </button>
            </div>

            <div id="description-content" class="tab-content">
                <h2 class="text-lg sm:text-xl font-bold mb-4">Product Description</h2>
                <div class="text-gray-700 leading-relaxed mb-6 prose max-w-none">
                    {!! $product->description !!}
                </div>

                <div class="container mx-auto px-0 py-8 sm:py-12">
                    <div class="mb-10 sm:mb-16">
                        <div class="flex flex-col md:flex-row items-center">
                            <h1 class="text-3xl sm:text-5xl min-w-[26%] font-medium text-rose-700">
                                <span class="block">Product</span>
                                <span class="text-rose-700 font-bold text-3xl sm:text-5xl w-full">Top Reviews</span>
                            </h1>
                            <div class="w-full h-1 bg-rose-300 mt-4 md:mt-0"></div>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="lg:w-3/4 relative">
                            <div class="testimonial-container relative">
                                <div class="testimonial-slide active" data-index="0">
                                    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm mb-6 sm:mb-8">
                                        <p class="text-base sm:text-lg text-gray-800 mb-4">"The simplicity and effectiveness
                                            of Afro Jee's
                                            products are unmatched. Even with just a few items, my skin feels healthier and
                                            more vibrant every day."</p>

                                        <div class="flex items-center mt-6">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                                <img src="/images/sami.png" alt="Jean Harper"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex text-yellow-400 mb-1">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="font-medium text-gray-700 text-sm sm:text-base">Jean Harper</p>
                                                <p class="text-xs sm:text-sm text-gray-500">Student</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="testimonial-slide" data-index="1">
                                    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm mb-6 sm:mb-8">
                                        <p class="text-base sm:text-lg text-gray-800 mb-4">"Afro Jee's natural ingredients
                                            have transformed my
                                            skincare routine. I've never received so many compliments on my skin!"</p>

                                        <div class="flex items-center mt-6">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                                <img src="/images/sami.png" alt="Reinette Akosua"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex text-yellow-400 mb-1">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="font-medium text-gray-700 text-sm sm:text-base">Reinette Akosua
                                                </p>
                                                <p class="text-xs sm:text-sm text-gray-500">Makeup Artist</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="testimonial-slide" data-index="2">
                                    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm mb-6 sm:mb-8">
                                        <p class="text-base sm:text-lg text-gray-800 mb-4">"As someone with sensitive skin,
                                            finding Afro Jee was
                                            a game-changer. Their products are gentle yet effective - exactly what I
                                            needed."</p>

                                        <div class="flex items-center mt-6">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                                <img src="/images/sami.png" alt="Sami Raimi"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex text-yellow-400 mb-1">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="font-medium text-gray-700 text-sm sm:text-base">Sami Raimi</p>
                                                <p class="text-xs sm:text-sm text-gray-500">Photographer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="testimonial-slide" data-index="3">
                                    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm mb-6 sm:mb-8">
                                        <p class="text-base sm:text-lg text-gray-800 mb-4">"The quality and attention to
                                            detail in every Afro Jee
                                            product is exceptional. I'm completely devoted to their skincare line!"</p>

                                        <div class="flex items-center mt-6">
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                                <img src="/images/sami.png" alt="Karma Yarn"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex text-yellow-400 mb-1">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="font-medium text-gray-700 text-sm sm:text-base">Karma Yarn</p>
                                                <p class="text-xs sm:text-sm text-gray-500">Fashion Designer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex mt-4">
                                <button id="prev-btn"
                                    class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7">
                                        </path>
                                    </svg>
                                </button>
                                <button id="next-btn"
                                    class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition ml-4">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </button>

                                <div class="ml-auto flex items-center">
                                    <a href="#"
                                        class="text-rose-700 font-medium flex items-center hover:underline text-sm sm:text-base">
                                        View All Reviews
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/4 mt-8 lg:mt-1">
                            <div class="space-y-4 sm:space-y-6">
                                <div class="flex items-center cursor-pointer client-nav opacity-50" data-index-client="0">
                                    <div
                                        class="client-nav-c w-8 h-8 sm:w-10 sm:h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                        <img src="/images/sami.png" alt="Jean Harper" class="w-full h-full object-cover">
                                    </div>
                                    <p class="ml-4 font-medium text-gray-700 text-sm sm:text-base">Jean Harper</p>
                                </div>

                                <div class="flex items-center cursor-pointer client-nav opacity-50" data-index-client="1">
                                    <div
                                        class="client-nav-c w-8 h-8 sm:w-10 sm:h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                                        <img src="/images/sami.png" alt="Reinette Akosua"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <p class="ml-4 font-medium text-gray-500 text-sm sm:text-base">Reinette Akosua</p>
                                </div>

                                <div class="flex items-center cursor-pointer client-nav opacity-50" data-index-client="2">
                                    <div
                                        class="client-nav-c w-8 h-8 sm:w-10 sm:h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                                        <img src="/images/sami.png" alt="Sami Raimi" class="w-full h-full object-cover">
                                    </div>
                                    <p class="ml-4 font-medium text-gray-500 text-sm sm:text-base">Sami Raimi</p>
                                </div>

                                <div class="flex items-center cursor-pointer client-nav opacity-50" data-index-client="3">
                                    <div
                                        class="client-nav-c w-8 h-8 sm:w-10 sm:h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                                        <img src="/images/karma.png" alt="Karma Yarn" class="w-full h-full object-cover">
                                    </div>
                                    <p class="ml-4 font-medium text-gray-500 text-sm sm:text-base">Karma Yarn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="ingredients-content" class="tab-content hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4">Ingredients</h2>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    {!! $product->ingredients !!}
                </div>
            </div>

            <div id="how-to-use-content" class="tab-content hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4">How To Use</h2>
                <div class="text-gray-700 leading-relaxed prose max-w-none">
                    {!! $product->how_to_use !!}
                </div>
            </div>

            <div id="reviews-content" class="tab-content hidden">
                <div
                    class="mb-6 flex flex-col sm:flex-row bg-white/80 justify-between p-4 sm:p-6 rounded-xl items-start sm:items-center gap-4 sm:gap-0">
                    <p class="text-gray-700 mb-2 sm:mb-0 font-bold text-sm sm:text-base">
                        Got thoughts on this product?
                    </p>
                    <button
                        class="bg-pink-800 hover:bg-pink-900 text-white px-4 py-2 sm:px-6 sm:py-2 rounded-full font-medium flex items-center gap-2 text-sm sm:text-base">
                        Leave A Review
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <div class="pt-6">
                    <h2 class="text-xl font-bold mb-8">Reviews</h2>

                    <div id="reviews-list">
                        <!-- Reviews will be dynamically loaded here by productDetail.js -->
                    </div>

                    <div
                        class="flex flex-col sm:flex-row justify-start items-center space-y-4 sm:space-y-0 sm:space-x-2 mt-8">
                        <button id="prevPage"
                            class="pagination-button text-pink-800 font-bold px-3 py-1 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1 text-sm sm:text-base">
                            <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="m7.41 11.572-4.58-4.59 4.58-4.59L6 .982l-6 6 6 6z" fill="#000" />
                            </svg>
                            <span class="ml-2 sm:ml-3">Previous</span>
                        </button>
                        <div id="pagination-numbers" class="flex space-x-2 text-gray-600">
                        </div>
                        <button id="nextPage"
                            class="pagination-button text-pink-800 font-bold px-3 py-1 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1 text-sm sm:text-base">
                            <span class="mr-2 sm:mr-3">Next</span>
                            <svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="m.824 2.392 4.58 4.59-4.58 4.59 1.41 1.41 6-6-6-6z" fill="#000" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection