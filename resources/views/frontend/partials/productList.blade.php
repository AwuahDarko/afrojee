<section class="bg-[#f7f3e9] py-16 px-6">
  <div class="max-w-6xl mx-auto text-center">
    <!-- Header -->
    <h2 class="text-5xl font-light text-gray-800">
      View <span class="font-bold text-gray-900">Our Products</span>
    </h2>
    <hr class="border-t border-gray-400 w-1/3 mx-auto my-4 opacity-50" />
    <p class="text-gray-700 mb-10 text-lg">
      Explore our collection and find the perfect products to elevate your beauty routine
    </p>

    <!-- Search Bar -->
    <div class="max-w-lg mx-auto mb-8 flex items-center bg-white border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
      <input
        type="text"
        placeholder="Enter product to search"
        class="flex-grow bg-transparent focus:outline-none text-gray-700"
      />
      <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
      </svg>
    </div>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap justify-center gap-4 mb-10">
      <button class="px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">All Products</button>
      <button class="px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">For Skin</button>
      <button class="px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">For Hair</button>
      <button class="px-4 py-2 border border-pink-700 text-pink-800 rounded-full hover:bg-pink-100">Others</button>
    </div>

    <!-- Product Grid -->
    <div class="grid gap-10 sm:grid-cols-2 md:grid-cols-3">
      <!-- Product Card -->
      <div class="text-left">
        <img src="/images/body-butter.png" alt="Body Butter" class="rounded-lg w-full mb-4" />
        <h3 class="font-semibold text-gray-800 text-lg mb-2">Always moisturized Body Butter</h3>
        <p class="text-gray-700 mb-4">$ 20.00</p>
        <div class="flex items-center gap-4">
          <button class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-2 rounded-full font-medium flex items-center gap-2">
            Buy Now
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
          </button>
          <button class="bg-white border border-pink-800 p-2 rounded-full text-pink-800 hover:bg-pink-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h14l1-5H6.4M7 13L5.6 6H21M7 13l-1.35 5.4A1 1 0 007 20h10a1 1 0 00.97-.76L20 13H7z" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Repeat the product card structure for other products -->
    </div>
  </div>
</section>
