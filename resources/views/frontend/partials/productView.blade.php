<!-- 

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="flex flex-col md:flex-row gap-8 mb-12">
            <div class="md:w-1/2 bg-white p-8 rounded-lg shadow-md flex items-center justify-center">
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                    [Product Image]
                </div>
            </div>
            

            <div class="md:w-1/2">
                <h1 class="title-font text-3xl font-bold text-gray-800 mb-2">Always Moisturized Body Butter</h1>
                <p class="text-2xl font-semibold text-gray-700 mb-6">$25.00</p>
                

                <div class="mb-6">
                    <p class="font-medium text-gray-700 mb-2">Quantity</p>
                    <div class="flex items-center border border-gray-300 rounded-md w-32">
                        <button id="decrement" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-l-md">-</button>
                        <span id="quantity" class="flex-1 text-center font-medium">1</span>
                        <button id="increment" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-r-md">+</button>
                    </div>
                </div>
                

                <button class="w-full bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-6 rounded-md mb-4 transition duration-300">
                    Buy Now
                </button>

                <p class="text-green-600 font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    FREE Shipping
                </p>
            </div>
        </div>
        
        <div class="border-t border-gray-200 my-6"></div>
        

        <div class="mb-8">
            <h2 class="title-font text-2xl font-bold text-gray-800 mb-4">Product Description</h2>
            <p class="text-gray-600 leading-relaxed">
                Transform your hair care routine with our Nourishing Shea Butter Hair Cream, a luxurious blend of rich shea butter, coconut oil, and natural botanicals. This cream deeply moisturizes and strengthens hair, leaving it soft, shiny, and manageable. Perfect for all hair types, especially dry or damaged hair, it provides lasting hydration without weighing your hair down. Use it daily to define curls, smooth frizz, or as a deep conditioning treatment for a healthy, vibrant look.
            </p>
        </div>
        
        <div class="border-t border-gray-200 my-6"></div>
        

        <div>
            <h2 class="title-font text-2xl font-bold text-gray-800 mb-4">Key Benefits</h2>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li>Deeply moisturizes and strengthens hair</li>
                <li>Reduces frizz and adds shine</li>
                <li>Perfect for styling and defining curls</li>
                <li>Suitable for all hair types</li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityElement = document.getElementById('quantity');
            const incrementButton = document.getElementById('increment');
            const decrementButton = document.getElementById('decrement');
            
            let quantity = 1;
            
            incrementButton.addEventListener('click', function() {
                quantity++;
                quantityElement.textContent = quantity;
            });
            
            decrementButton.addEventListener('click', function() {
                if (quantity > 1) {
                    quantity--;
                    quantityElement.textContent = quantity;
                }
            });
        });
    </script> -->


    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row p-6">
            <div class="md:w-1/2 flex justify-center items-center p-4">
                <img src="/images/p3.png" alt="Always Moisturize Body Butter" class="rounded-lg shadow-md max-w-full h-auto">
            </div>

            <div class="md:w-1/2 p-4">
                <h1 class="text-3xl font-bold mb-2">Always moisturized Body Butter</h1>
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.286L12 18.896l-7.416 3.924 1.48-8.286-6.064-5.828 8.332-1.151z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.286L12 18.896l-7.416 3.924 1.48-8.286-6.064-5.828 8.332-1.151z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.286L12 18.896l-7.416 3.924 1.48-8.286-6.064-5.828 8.332-1.151z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.286L12 18.896l-7.416 3.924 1.48-8.286-6.064-5.828 8.332-1.151z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.286L12 18.896l-7.416 3.924 1.48-8.286-6.064-5.828 8.332-1.151z"/></svg>
                    </div>
                </div>
                <p class="text-4xl font-semibold mb-6">$ 25.00</p>

                <div class="flex items-center mb-6">
                    <span class="mr-4 text-lg">Quantity</span>
                    <div class="flex items-center border border-gray-300 rounded-md">
                        <button id="decrement" class="px-3 py-1 text-xl font-bold text-gray-600 hover:bg-gray-100 rounded-l-md">-</button>
                        <input type="text" id="quantity" value="1" class="w-12 text-center border-l border-r border-gray-300 focus:outline-none" readonly>
                        <button id="increment" class="px-3 py-1 text-xl font-bold text-gray-600 hover:bg-gray-100 rounded-r-md">+</button>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button class="btn-primary flex items-center justify-center px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition duration-300 ease-in-out">
                        Buy Now
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <button class="flex items-center justify-center px-4 py-3 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition duration-300 ease-in-out">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-8 px-6 pb-6">
            <div class="flex space-x-4 border-b border-gray-200 mb-6">
                <button class="tab-button px-6 py-3 rounded-t-lg font-semibold text-gray-700 hover:bg-gray-100 active" data-tab="description">Description</button>
                <button class="tab-button px-6 py-3 rounded-t-lg font-semibold text-gray-700 hover:bg-gray-100" data-tab="ingredients">Ingredients</button>
                <button class="tab-button px-6 py-3 rounded-t-lg font-semibold text-gray-700 hover:bg-gray-100" data-tab="how-to-use">How To Use</button>
                <button class="tab-button px-6 py-3 rounded-t-lg font-semibold text-gray-700 hover:bg-gray-100" data-tab="reviews">Reviews</button>
            </div>

            <div id="description-content" class="tab-content">
                <h2 class="text-2xl font-bold mb-4">Product Description</h2>
                <p class="text-gray-700 leading-relaxed">
                    Transform your hair care routine with our Nourishing Shea Butter Hair Cream, a luxurious blend of rich shea butter, coconut oil, and natural botanicals. This cream deeply moisturizes and strengthens hair, leaving it soft, shiny, and manageable. Perfect for all hair types, especially dry or damaged hair, it provides lasting hydration without weighing your hair down. Use it daily to define curls, smooth frizz, or as a deep conditioning treatment for a healthy, vibrant look.
                </p>
            </div>

            <div id="ingredients-content" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">Ingredients</h2>
                <ul class="list-disc list-inside text-gray-700">
                    <li>Shea Butter</li>
                    <li>Coconut Oil</li>
                    <li>Argan Oil</li>
                    <li>Jojoba Oil</li>
                    <li>Vitamin E</li>
                    <li>Essential Oils (Lavender, Rosemary)</li>
                    <li>Natural Fragrance</li>
                </ul>
            </div>

            <div id="how-to-use-content" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">How To Use</h2>
                <p class="text-gray-700 leading-relaxed">
                    Apply a small amount to damp or dry hair, focusing on mid-lengths and ends. Style as desired. For deep conditioning, apply a generous amount to clean, damp hair, leave on for 15-20 minutes, then rinse thoroughly.
                </p>
            </div>

            <div id="reviews-content" class="tab-content hidden">
                <h2 class="text-2xl font-bold mb-4">Reviews</h2>
                <p class="text-gray-700">No reviews yet. Be the first to review this product!</p>
                </div>

            <div class="mt-8 p-6 rounded-lg" style="background-color: var(--color-primary);">
                <h3 class="text-xl font-bold text-white mb-4">Key Benefits</h3>
                <ul class="list-disc list-inside text-white space-y-2">
                    <li>Deeply moisturizes and strengthens hair</li>
                    <li>Reduces frizz and adds shine</li>
                    <li>Perfect for styling and defining curls</li>
                    <li>Suitable for all hair types</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Quantity Counter Logic
            const decrementButton = document.getElementById('decrement');
            const incrementButton = document.getElementById('increment');
            const quantityInput = document.getElementById('quantity');

            decrementButton.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            incrementButton.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });

            // Tab Switching Logic
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons and hide all content
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Add active class to the clicked button
                    button.classList.add('active');

                    // Show the corresponding content
                    const targetTab = button.dataset.tab;
                    document.getElementById(`${targetTab}-content`).classList.remove('hidden');
                });
            });
        });
    </script>