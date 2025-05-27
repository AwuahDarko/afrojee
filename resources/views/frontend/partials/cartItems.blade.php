<section class="max-w-6xl mx-auto py-12">
    <h1 class="text-4xl font-semibold text-gray-800 mb-8">Your Cart</h1>

    <div class="grid md:grid-cols-3 gap-8">
        <div id="cart-items-container" class="md:col-span-2 bg-white rounded-xl p-4 shadow-sm">
            <div class="cart-item flex items-center p-4" data-price="20.00">
                <img src="/images/p3.png" alt="Product Image"
                    class="w-20 h-20 rounded-lg mr-4">
                <div class="flex-grow">
                    <h1 class="font-semibold pb-10 text-lg">Always moisturized Body Butter</h1>
                    <div class="flex items-center text-gray-600 align-middle">
                        <p class="text-pink-800 font-bold text-xl mr-4 border-r-2 pr-5">$ 20.00</p>
                        <span class="mr-2 font-bold">Quantity</span>
                        <button
                            class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200">-</button>
                        <input type="text" value="2"
                            class="quantity-input w-10 text-center mx-2 border-none focus:outline-none bg-transparent"
                            readonly>
                        <button
                            class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 mr-auto">+</button>
                        <button class="delete-item ml-4 text-gray-500 hover:text-red-600 transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-300 mx-4"></div>


            <div class="cart-item flex items-center p-4" data-price="20.00">
                <img src="/images/p3.png" alt="Product Image"
                    class="w-20 h-20 rounded-lg mr-4">
                <div class="flex-grow">
                    <h1 class="font-semibold pb-10 text-lg">Always moisturized Body Butter</h1>
                    <div class="flex items-center text-gray-600 align-middle">
                        <p class="text-pink-800 font-bold text-xl mr-4 border-r-2 pr-5">$ 20.00</p>
                        <span class="mr-2 font-bold">Quantity</span>
                        <button
                            class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200">-</button>
                        <input type="text" value="2"
                            class="quantity-input w-10 text-center mx-2 border-none focus:outline-none bg-transparent"
                            readonly>
                        <button
                            class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 mr-auto">+</button>
                        <button class="delete-item ml-4 text-gray-500 hover:text-red-600 transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-300 mx-4"></div>

            <div class="cart-item flex items-center p-4" data-price="20.00">
                <img src="/images/p3.png" alt="Product Image"
                    class="w-20 h-20 rounded-lg mr-4">
                <div class="flex-grow">
                    <h1 class="font-semibold pb-10 text-lg">Always moisturized Body Butter</h1>
                    <div class="flex items-center text-gray-600 align-middle">
                        <p class="text-pink-800 font-bold text-xl mr-4 border-r-2 pr-5">$ 20.00</p>
                        <span class="mr-2 font-bold">Quantity</span>
                        <button
                            class="quantity-minus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200">-</button>
                        <input type="text" value="2"
                            class="quantity-input w-10 text-center mx-2 border-none focus:outline-none bg-transparent"
                            readonly>
                        <button
                            class="quantity-plus px-2 py-1 border border-gray-300 rounded-full hover:bg-gray-100 transition duration-200 mr-auto">+</button>
                        <button class="delete-item ml-4 text-gray-500 hover:text-red-600 transition duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-1 bg-white rounded-xl p-6 shadow-sm h-fit sticky top-8">
            <div class="flex justify-between items-center mb-4">
                <p class="text-lg text-gray-700">Sub-total (<span id="cart-item-count">0</span> items)</p>
                <p class="text-xl font-bold text-gray-900">$ <span id="cart-subtotal">0.00</span></p>
            </div>
            <button
                class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-3 rounded-full font-medium w-full flex items-center justify-center gap-2 mb-6">
                Proceed to checkout
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
            <div class="flex justify-center space-x-3">
                <img src="https://via.placeholder.com/40x25/F0EAD6/8A3641?text=VISA" alt="Visa"
                    class="h-6 object-contain">
                <img src="https://via.placeholder.com/40x25/F0EAD6/8A3641?text=MC" alt="Mastercard"
                    class="h-6 object-contain">
                <img src="https://via.placeholder.co/40x25/F0EAD6/8A3641?text=AMEX" alt="American Express"
                    class="h-6 object-contain">
                <img src="https://via.placeholder.co/40x25/F0EAD6/8A3641?text=PayPal" alt="PayPal"
                    class="h-6 object-contain">
            </div>
        </div>
    </div>
</section>