@extends('frontend.layouts.app')

@section('title')
    Afrojee - Browse our products
@endsection

@section('content')
    <section class="bg-[#f7f3e9] py-16 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <div class="mb-12">
                <div class="flex items-center mb-2">
                    <h2 class="text-2xl md:text-5xl lg:text-6xl text-left font-light text-taupe mb-2">
                        View <br /><span class="font-bold">Our Products</span>
                    </h2>
                    <div class="bg-taupe h-1 backdrop-blur-sm w-full min-w-lg mt-4 mb-8"></div>
                </div>
                <p class="text-taupe text-lg md:text-xl max-w-4xl">
                    Explore our collection and find the perfect products to elevate your
                    beauty routine
                </p>
            </div>

            <form action="{{route('web.product.search')}}" method="GET">
                <div
                    class="max-w-lg mb-8 flex justify-start items-center bg-white border border-gray-300 rounded-lg px-4 py-2 shadow-sm w-full">
                    <input name="q" id="productSearch" type="text" placeholder="Enter product to search"
                        class="flex-grow bg-transparent focus:outline-none text-gray-700" value="{{ $_GET['q'] ?? '' }}" />
                    <button type="submit">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="flex flex-wrap justify-start gap-4 mb-10 overflow-x-auto pb-2">
                <a href="{{ route('web.products') }}" data-filter="all"
                    class="filter-btn flex-shrink-0 px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-colors duration-200 {{ request()->routeIs('web.products') ? 'active-filter bg-pink-100' : '' }}">
                    All Products
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('web.products.filterByCategory', ['slug' => $category->slug]) }}"
                        data-filter="{{ strtolower(str_replace(' ', '-', $category->name)) }}"
                        class="filter-btn flex-shrink-0 px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100 transition-colors duration-200 {{ request()->routeIs('web.products.filterByCategory') && request()->route('slug') == $category->slug ? 'active-filter bg-pink-100' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div id="productGrid" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div class="product-card text-left group transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg rounded-lg"
                        data-category="{{ strtolower(str_replace(' ', '-', $product->category->name)) }}">
                        <a href="{{route('web.products.details', ['slug' => $product->slug])}}">
                            <div class="w-full h-80 overflow-hidden rounded-lg mb-4">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover object-center" />
                            </div>
                        </a>
                        <h3 class="font-semibold text-gray-800 text-lg mb-2">
                            <a href="{{route('web.products.details', ['slug' => $product->slug])}}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-gray-700 mb-4">
                            ${{ number_format($product->price, 2) }}
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('web.checkoutDetails.single', ['product_id' => $product->id]) }}" class="flex-grow">
                                <button
                                    class="bg-pink-800 hover:bg-pink-900 text-white w-full justify-center px-6 py-2 rounded-full font-medium flex items-center gap-2 transition-colors duration-200">
                                    Buy Now
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#a)">
                                            <g clip-path="url(#b)">
                                                <g clip-path="url(#c)">
                                                    <mask id="d" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0"
                                                        y="0" width="31" height="32">
                                                        <path d="M31 .5v31H0V.5z" fill="#fff" />
                                                    </mask>
                                                    <g mask="url(#d)">
                                                        <path
                                                            d="M17.558 24.318 25.834 16l-8.276-8.32a.86.86 0 1 0-1.196 1.215l6.19 6.242H6.08a.861.861 0 1 0 0 1.723h16.473l-6.191 6.243a.86.86 0 0 0-.011 1.233.86.86 0 0 0 1.233-.019z"
                                                            fill="#fff" />
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="a">
                                                <path fill="#fff" d="M0 .5h31v31H0z" />
                                            </clipPath>
                                            <clipPath id="b">
                                                <path fill="#fff" d="M0 .5h31v31H0z" />
                                            </clipPath>
                                            <clipPath id="c">
                                                <path fill="#fff" d="M0 .5h31v31H0z" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </a>
                            <button
                                class="cart-item-btn bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100 transition-colors duration-200 flex-shrink-0"
                                id="add-to-cart-button"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-price="{{ number_format($product->price, 2) }}"
                                data-product-image="{{ $product->image }}">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#a)" fill="#99395C">
                                        <path
                                            d="M21.25 22.5a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.113-2.5 2.5-2.5m-20-20h4.088L6.513 5H25a1.25 1.25 0 0 1 1.25 1.25c0 .213-.062.425-.15.625l-4.475 8.088a2.51 2.51 0 0 1-2.187 1.287h-9.313L9 18.288l-.037.15a.313.313 0 0 0 .312.312H23.75v2.5h-15a2.5 2.5 0 0 1-2.5-2.5c0-.437.112-.85.3-1.2l1.7-3.062L3.75 5h-2.5zm7.5 20a2.5 2.5 0 1 1-2.5 2.5c0-1.387 1.112-2.5 2.5-2.5M20 13.75l3.475-6.25h-15.8l2.95 6.25z" />
                                        <path d="M25 15.5v6h6v4h-6v6h-4v-6h-6v-4h6v-6z" stroke="#F4F3E7" stroke-width="2" />
                                    </g>
                                    <defs>
                                        <clipPath id="a">
                                            <path fill="#fff" d="M0 0h30v30H0z" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center items-center space-x-2 mt-8">

            <a href="{{ $products->previousPageUrl() }}"
                class="pagination-button text-pink-800 font-bold px-4 py-2 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1 {{ $products->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m7.41 11.572-4.58-4.59 4.58-4.59L6 .982l-6 6 6 6z" fill="#000"></path>
                </svg>
                <span class="ml-3">Previous</span>
            </a>

            @php
                $current = $products->currentPage();
                $last = $products->lastPage();
            @endphp

            <div class="flex space-x-2 text-gray-600">
                {{-- First page --}}
                @if ($current > 3)
                    <a href="{{ $products->url(1) }}"
                        class="pagination-button px-3 py-1 rounded-full font-medium border border-transparent hover:border-pink-800 transition duration-300">
                        1
                    </a>
                    @if ($current > 4)
                        <span class="px-2 py-1">...</span>
                    @endif
                @endif

                {{-- Pages around current --}}
                @for ($i = max(1, $current - 2); $i <= min($last, $current + 2); $i++)
                    <a href="{{ $products->url($i) }}"
                        class="pagination-button px-3 py-1 rounded-full font-medium border border-transparent hover:border-pink-800 transition duration-300 {{ $i === $current ? 'bg-pink-800 text-white' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Last page --}}
                @if ($current < $last - 2)
                    @if ($current < $last - 3)
                        <span class="px-2 py-1">...</span>
                    @endif
                    <a href="{{ $products->url($last) }}"
                        class="pagination-button px-3 py-1 rounded-full font-medium border border-transparent hover:border-pink-800 transition duration-300">
                        {{ $last }}
                    </a>
                @endif
            </div>

            <a href="{{ $products->nextPageUrl() }}"
                class="pagination-button text-pink-800 font-bold px-4 py-2 rounded-full border border-transparent hover:border-pink-800 transition duration-300 flex items-center space-x-1 {{ $products->currentPage() == $products->lastPage() ? 'pointer-events-none opacity-50' : '' }}">
                <span class="mr-3">Next</span>
                <svg width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="m.824 2.392 4.58 4.59-4.58 4.59 1.41 1.41 6-6-6-6z" fill="#000"></path>
                </svg>
            </a>
        </div>
    </section>
@endsection