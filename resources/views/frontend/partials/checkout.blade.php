<section class="max-w-6xl mx-auto py-12">
    <h1 class="text-4xl font-semibold text-gray-800 mb-8">Checkout</h1>

    <h2 class="text-xl font-semibold text-gray-800">Billing address</h2>
    <div class="grid md:grid-cols-2 gap-8">
        <div>
            <div class="bg-pink-100-light rounded-xl p-6 shadow-sm mb-8">
                <div class="flex justify-between items-center mb-4">
                    <a href="#" class="text-pink-700 hover:text-pink-800 font-medium">Change address</a>
                </div>
                <div class="text-gray-700 leading-relaxed">
                    <p class="font-bold">Bridget Serwaa</p>
                    <p>Texas</p>
                    <p>Knoxville</p>
                    <p>19889 Biz street</p>
                    <p>United States</p>
                    <p>+ 1234567890</p>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Card Details</h2>

                <div class="mb-4">
                    <label for="cardNumber" class="block text-gray-700 text-sm font-medium mb-2">Card Number</label>
                    <div class="relative">
                        <input type="text" id="cardNumber" placeholder="Enter card number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                        <svg class="w-6 h-6 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="expiryDate" class="block text-gray-700 text-sm font-medium mb-2">Expiry Date</label>
                        <input type="text" id="expiryDate" placeholder="MM/YY"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                    </div>
                    <div>
                        <label for="cvv" class="block text-gray-700 text-sm font-medium mb-2">CVV</label>
                        <input type="text" id="cvv" placeholder="Enter CVV"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="nameOnCard" class="block text-gray-700 text-sm font-medium mb-2">Name on Card</label>
                    <input type="text" id="nameOnCard" placeholder="Enter the name on the card"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800">
                </div>

                <button
                    class="bg-pink-200-light hover:bg-pink-300-light text-pink-800 font-semibold px-6 py-3 rounded-full w-full transition duration-300 ease-in-out">
                    Use this card
                </button>
            </div>
        </div>

        <div class="md:col-span-1 bg-white rounded-xl p-6 shadow-sm h-fit sticky top-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Your Bill</h2>
            <div class="flex justify-between items-center mb-3">
                <p class="text-gray-700">Product sub-total</p>
                <p class="font-bold text-gray-900">$ 60.00</p>
            </div>
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-700">Delivery</p>
                <p class="font-bold text-gray-900">$ 15.99</p>
            </div>
            <div class="flex justify-between items-center border-t border-gray-300 pt-4 mb-6">
                <p class="text-xl font-bold text-gray-900">Total</p>
                <p class="text-3xl font-bold text-gray-900">$ 75.99</p>
            </div>
            <button
                class="bg-pink-800 hover:bg-pink-900 text-white px-6 py-3 rounded-full font-medium w-full flex items-center justify-center gap-2">
                Proceed to checkout
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>