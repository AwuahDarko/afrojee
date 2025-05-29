<script src="{{ asset('js/productDetail.js') }}"></script>

@extends('frontend.layouts.app')

@section('title')
    Afrojee - {{$product->name}}
@endsection





@section('content')
<section class="bg-[#f7f3e9] py-16 px-4 md:px-8 text-gray-800">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-start">
        <!-- Product Image -->
        <div class="flex justify-center">
            <img src="{{$product->image}}" alt="Body Butter" class="rounded-xl w-72" />
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-2xl font-semibold mb-2">
                {{$product->name}}
            </h1>

            <!-- Star Rating -->
            <div class="flex items-center text-yellow-400 mb-4">
                <span>★★★★★</span>
            </div>

            <!-- Price -->
            <p class="text-3xl font-bold text-gray-900 mb-6">$ {{ number_format($product->price, 2) }}</p>

            <!-- Quantity Selector -->
            <div class="flex items-center mb-6">
                <span class="mr-1 font-bold">Quantity</span>
                <div class="flex items-center space-x-4 px-4 py-1">
                    <button id="decrement"
                        class="text-lg font-bold text-gray-600 rounded-full border border-[var(--color-primary)] p-2 w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition duration-300 ease-in-out">
                        −
                    </button>
                    <input type="text" id="quantity" value="1"
                        class="w-12 text-center focus:outline-none bg-transparent text-xl font-bold" readonly />
                    <button id="increment"
                        class="text-lg font-bold text-gray-600 rounded-full border border-[var(--color-primary)] p-2 w-10 h-10 flex items-center justify-center hover:bg-gray-100 transition duration-300 ease-in-out">
                        +
                    </button>
                </div>

                <!-- Buy Now -->
                <div class="ml-6 flex items-center gap-4">
                    <button
                        class="relative bg-pink-800 hover:bg-pink-900 text-white px-6 py-2 rounded-full font-medium flex items-center gap-2">
                        <span id="buyNowCounter"
                            class="absolute -left-3 -top-3 text-xs bg-white text-pink-800 border border-pink-800 rounded-full px-2 py-0.5 font-bold shadow">
                            1 </span>Buy Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button
                        class="relative bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100">
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
                            class="absolute -left-2 -top-2 text-xs bg-pink-800 text-white rounded-full px-2 py-0.5 font-bold shadow">
                            1
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mt-12">
        <!-- Tab Navigation -->
        <div class="flex gap-4 mt-4 mb-6">
            <button class="tab-button border border-pink-700 px-4 py-2 rounded-full text-pink-800 font-medium active"
                data-tab="description">
                Description
            </button>
            <button class="tab-button border border-pink-700 px-4 py-2 rounded-full text-pink-800 hover:bg-pink-100"
                data-tab="ingredients">
                Ingredients
            </button>
            <button class="tab-button border border-pink-700 px-4 py-2 rounded-full text-pink-800 hover:bg-pink-100"
                data-tab="how-to-use">
                How To Use
            </button>
            <button class="tab-button border border-pink-700 px-4 py-2 rounded-full text-pink-800 hover:bg-pink-100"
                data-tab="reviews">
                Reviews
            </button>
        </div>
    </div>
    <!-- Description Content -->
    <div id="description-content" class="tab-content max-w-4xl mx-auto mt-12">
        <h2 class="text-xl font-bold mb-4">Product Description</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
           {!! $product->description !!}
        </p>

        <!-- Key Benefits -->
        <div class="bg-pink-800 text-white rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Key Benefits</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>Deeply moisturizes and strengthens hair</li>
                <li>Reduces frizz and adds shine</li>
                <li>Perfect for styling and defining curls</li>
                <li>Suitable for all hair types</li>
            </ul>
        </div>

        <div class="container mx-auto px-4 py-12">
        <div class="mb-16">
            <div class="flex flex-col md:flex-row items-center">
                <h1 class="text-5xl min-w-[26%] font-medium text-rose-700">
                    <span class="block">Product</span>
                    <span class="text-rose-700 font-bold text-5xl w-full">Top Reviews</span>
                </h1>
                <div class="w-full h-1 bg-rose-300 mt-4 md:mt-0"></div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Content - Testimonials -->
            <div class="lg:w-3/4 relative">

                <!-- Testimonial Slides -->
                <div class="testimonial-container relative">
                    <div class="testimonial-slide active" data-index="0">
                        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-800 mb-4">"The simplicity and effectiveness of YaaSerwa's
                                products are unmatched. Even with just a few items, my skin feels healthier and more
                                vibrant every day."</p>

                            <div class="flex items-center mt-6">
                                <div
                                    class="w-12 h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                    <img src="/images/sami.png" alt="Jean Harper" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-yellow-400 mb-1">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-700">Jean Harper</p>
                                    <p class="text-sm text-gray-500">Student</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-slide" data-index="1">
                        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-800 mb-4">"YaaSerwa's natural ingredients have transformed my
                                skincare routine. I've never received so many compliments on my skin!"</p>

                            <div class="flex items-center mt-6">
                                <div
                                    class="w-12 h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                    <img src="/images/sami.png" alt="Reinette Akosua"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-yellow-400 mb-1">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-700">Reinette Akosua</p>
                                    <p class="text-sm text-gray-500">Makeup Artist</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-slide" data-index="2">
                        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-800 mb-4">"As someone with sensitive skin, finding YaaSerwa was
                                a game-changer. Their products are gentle yet effective - exactly what I needed."</p>

                            <div class="flex items-center mt-6">
                                <div
                                    class="w-12 h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                    <img src="/images/sami.png" alt="Sami Raimi" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-yellow-400 mb-1">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-700">Sami Raimi</p>
                                    <p class="text-sm text-gray-500">Photographer</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-slide" data-index="3">
                        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-800 mb-4">"The quality and attention to detail in every YaaSerwa
                                product is exceptional. I'm completely devoted to their skincare line!"</p>

                            <div class="flex items-center mt-6">
                                <div
                                    class="w-12 h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                    <img src="/images/sami.png" alt="Karma Yarn" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-yellow-400 mb-1">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-700">Karma Yarn</p>
                                    <p class="text-sm text-gray-500">Fashion Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <div class="flex mt-4">
                    <button id="prev-btn"
                        class="w-12 h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <button id="next-btn"
                        class="w-12 h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition ml-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <div class="ml-auto">
                        <a href="#" class="text-rose-700 font-medium flex items-center hover:underline">
                            View All Reviews
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Content - Client List -->
            <div class="lg:w-1/4 mt-12 lg:mt-1">
                <div class="space-y-6">
                    <!-- Jean Harper -->
                    <div class="flex items-center cursor-pointer client-nav" data-index="0">
                        <div class="w-10 h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                            <img src="/images/sami.png" alt="Jean Harper" class="w-full h-full object-cover">
                        </div>
                        <p class="ml-4 font-medium text-gray-700">Jean Harper</p>
                    </div>

                    <!-- Reinette Akosua -->
                    <div class="flex items-center cursor-pointer client-nav opacity-50" data-index="1">
                        <div class="w-10 h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                            <img src="/images/sami.png" alt="Reinette Akosua" class="w-full h-full object-cover">
                        </div>
                        <p class="ml-4 font-medium text-gray-500">Reinette Akosua</p>
                    </div>

                    <!-- Sami Raimi -->
                    <div class="flex items-center cursor-pointer client-nav opacity-50" data-index="2">
                        <div class="w-10 h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                            <img src="/images/sami.png" alt="Sami Raimi" class="w-full h-full object-cover">
                        </div>
                        <p class="ml-4 font-medium text-gray-500">Sami Raimi</p>
                    </div>

                    <!-- Karma Yarn -->
                    <div class="flex items-center cursor-pointer client-nav opacity-50" data-index="3">
                        <div class="w-10 h-10 bg-rose-100 rounded-full overflow-hidden border-2 border-gray-300">
                            <img src="/images/karma.png" alt="Karma Yarn" class="w-full h-full object-cover">
                        </div>
                        <p class="ml-4 font-medium text-gray-500">Karma Yarn</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="ingredients-content" class="tab-content hidden max-w-4xl mx-auto mt-12">
        <h2 class="text-xl font-bold mb-4">Ingredients</h2>
        <ul class="list-disc list-inside text-gray-700">
            <li>Cocoa Oil</li>
            <li>Cocoa Oil</li>
            <li>Cocoa Oil</li>
            <li>Cocoa Oil</li>
            <li>Cocoa Oil</li>
            <li>Cocoa Oil</li>
        </ul>

        <div class="bg-white/80 text-white rounded-xl p-6 mt-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="heart-pulse">
                    <svg width="34" height="31" viewBox="0 0 34 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.595 2.953a10.06 10.06 0 0 1 .395 13.809L16.772 31 2.557 16.762A10.06 10.06 0 0 1 13.858.744l-6.57 6.57L9.66 9.686l7.114-7.114-.022-.023.023.021a10.06 10.06 0 0 1 13.82.383"
                            fill="#99395C" />
                    </svg>
                </div>
                <h1 class="text-4xl md:text-2xl font-bold text-rose-800">
                    Ethically-sourced Ingredients
                </h1>
            </div>
            <div class="flex items-center gap-4 mb-8">
                <div class="w-40"></div>
                <p class="text-lg md:text-l leading-relaxed text-gray-700 font-medium">
                    We are committed to ethical sourcing and sustainability. Our
                    ingredients are responsibly harvested and processed to
                    ensure the highest quality while supporting environmental
                    conservation and fair trade practices.
                </p>
            </div>
        </div>
    </div>

    <div id="how-to-use-content" class="tab-content hidden max-w-4xl mx-auto mt-12">
        <h2 class="text-xl font-bold mb-4">How To Use</h2>
        <ol class="list-decimal list-inside text-gray-700 leading-relaxed">
            <li>
                <b>Prep your skin:</b> For best results, apply after a shower or
                bath when your skin is clean and slightly damp.
            </li>
            <li>
                <b>Scoop a Small Amount:</b> A little goes a long way! Use your
                fingers to scoop a small amount of body butter
            </li>
            <li>
                <b>Warm it Up:</b> Rub the butter between your palms to warm it
                up and make it easier to spread
            </li>
            <li>
                <b>Let it Absorb:</b> Allow a few moments for the butter to sink
                in and hydrate your skin
            </li>
        </ol>
    </div>

    <div id="reviews-content" class="tab-content hidden max-w-4xl mx-auto mt-12">
        <div class="mb-6 flex bg-white/80 justify-between p-6 rounded-xl">
            <p class="text-gray-700 mb-2 font-bold">
                Got thoughts on this product?
            </p>
            <button
                class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-2 rounded-full font-medium flex items-center gap-2">
                Leave A Review
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <div class="pt-6">
            <h2 class="text-xl font-bold mb-30">Reviews</h2>

            <!-- <div class="border-b border-gray-300 pb-5">
                <div class="flex items-center mb-2">
                    <img
                        src="https://placehold.co/30x30/99395C/FFFFFF?text=M"
                        alt="User Avatar"
                        class="rounded-full mr-2"
                    />
                    <span class="font-semibold">Maya, 23</span>
                </div>
                <h2 class="text-xl font-bold mb-4">
                    Thee growth hair & scalp oil
                </h2>
                <p class="text-gray-700 italic mb-2">
                    "This body butter is a game-changer! My skin feels so soft
                    and hydrated, and the scent is absolutely divine. A little
                    goes a long way, so it's great value for money. Highly
                    recommend!"
                </p>
                <div class="flex text-yellow-400 text-3xl">
                    <span>★★★★☆</span>
                </div>
            </div> -->
            <div id="reviews-list">
            </div>

            <div class="flex justify-start items-center space-x-2 mt-8">
                <button id="prevPage"
                    class="pagination-button text-pink-800 font-bold px-1 py-1 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1">
                    <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m7.41 11.572-4.58-4.59 4.58-4.59L6 .982l-6 6 6 6z" fill="#000" />
                    </svg>
                    <span class="ml-3">Previous</span>
                </button>
                <div id="pagination-numbers" class="flex space-x-2 text-gray-600">
                </div>
                <button id="nextPage"
                    class="pagination-button text-pink-800 font-bold px-3 py-1 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1">
                    <span class="mr-3">Next</span>
                    <svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m.824 2.392 4.58 4.59-4.58 4.59 1.41 1.41 6-6-6-6z" fill="#000" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection