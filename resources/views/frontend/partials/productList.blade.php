@extends('frontend.layouts.app')
@section('content')
  <section class="bg-[#f7f3e9] py-16 px-6">
    <div class="max-w-7xl mx-auto text-center">
    <!-- Header -->
    <div class="mb-12">
      <div class="flex items-center mb-2">
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe mb-2">
        View <br><span class="font-bold">Our Products</span>
      </h2>
      <div class="bg-taupe h-1 backdrop-blur-sm  w-full min-w-lg mt-4 mb-8"></div>
      </div>
      <p class="text-taupe text-lg md:text-xl max-w-4xl">
      Explore our collection and find the perfect products to elevate your beauty routine
      </p>
    </div>
    <!-- Search Bar -->
    <div
      class="max-w-lg mb-8 flex justify-start items-center bg-white border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
      <input type="text" placeholder="Enter product to search"
      class="flex-grow bg-transparent focus:outline-none text-gray-700" />
      <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
      </svg>
    </div>

    <!-- Filter Buttons -->
    <!-- <div class="flex flex-wrap justify-start gap-4 mb-10">
      <button data-filter="all" class="filter-btn active-filter px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">All
      Products</button>
      <button data-filter="skin" class="filter-btn px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">For Skin</button>
      <button data-filter="hair" class="filter-btn px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">For Hair</button>
      <button data-filter="others" class="filter-btn px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">Others</button>
    </div> -->
    <div class="flex flex-wrap justify-start gap-4 mb-10">
      <a href="{{ route('web.products') }}"
      class="filter-btn {{ is_null($filter) ? 'active-filter' : '' }} px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">
      All Products
      </a>
      <a href="{{ route('web.products', ['category' => 'skin']) }}"
      class="filter-btn {{ $filter === 'skin' ? 'active-filter' : '' }} px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">
      For Skin
      </a>
      <a href="{{ route('web.products', ['category' => 'hair']) }}"
      class="filter-btn {{ $filter === 'hair' ? 'active-filter' : '' }} px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">
      For Hair
      </a>
      <a href="{{ route('web.products', ['category' => 'others']) }}"
      class="filter-btn {{ $filter === 'others' ? 'active-filter' : '' }} px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">
      Others
      </a>
    </div>
    <!-- Product Grid -->
    <!-- Product Card -->
    <!-- <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3">
      <div class="text-left">
      <img src="/images/body-butter.png" alt="Body Butter" class="rounded-lg w-full mb-4" />
      <h3 class="font-semibold text-gray-800 text-lg mb-2">Always moisturized Body Butter</h3>
      <p class="text-gray-700 mb-4">$ 20.00</p>
      <div class="flex items-center gap-4">
        <button
        class="bg-pink-800 hover:bg-pink-900 text-white w-full justify-center px-6 py-2 rounded-full font-medium flex items-center gap-2">
        Buy Now
        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#a)">
          <g clip-path="url(#b)">
            <g clip-path="url(#c)">
            <mask id="d" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="31"
              height="32">
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
        <button class="bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="M3 3h2l.4 2M7 13h14l1-5H6.4M7 13L5.6 6H21M7 13l-1.35 5.4A1 1 0 007 20h10a1 1 0 00.97-.76L20 13H7z" />
        </svg>
        </button>
      </div>
      </div>

    </div> -->
    <!-- Repeat the product card structure for other products -->
    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3">
  @foreach($products as $product)
  <div class="text-left product-card" data-category="{{ $product->category->slug }}">
    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded-lg w-full mb-4" />
    <h3 class="font-semibold text-gray-800 text-lg mb-2">{{ $product->name }}</h3>
    <p class="text-gray-700 mb-4">$ {{ number_format($product->price, 2) }}</p>
    <div class="flex items-center gap-4">
      <button class="bg-pink-800 hover:bg-pink-900 text-white w-full justify-center px-6 py-2 rounded-full font-medium flex items-center gap-2">
        Buy Now
        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#a)">
          <g clip-path="url(#b)">
            <g clip-path="url(#c)">
            <mask id="d" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="31"
              height="32">
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
      <button class="bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h2l.4 2M7 13h14l1-5H6.4M7 13L5.6 6H21M7 13l-1.35 5.4A1 1 0 007 20h10a1 1 0 00.97-.76L20 13H7z" />
        </svg>
      </button>
    </div>
  </div>
  @endforeach
</div> 
  </div>
  </section>
@endsection