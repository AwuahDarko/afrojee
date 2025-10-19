<footer class="bg-footergold text-white py-12">
    <div class="container mx-auto px-4 md:px-8">
        <!-- Logo Section -->
        <div class="mb-10">
            <h2 class="text-3xl font-bold text-white">AFRO JEE</h2>
        </div>

        <!-- Footer Navigation -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <!-- About Us Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">About Us</h3>
                <ul class="space-y-3">
                    <li><a href="/about#our-mission" class="hover:underline">Our Mission</a></li>
                    <li><a href="/about#our-mission" class="hover:underline">Our Vision</a></li>
                    <li><a href="/about#our-coverage" class="hover:underline">Our Coverage</a></li>
                </ul>
            </div>

            <!-- FAQs Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">FAQs</h3>
                <ul class="space-y-3">
                    <li><a href="#shipping-faq" class="hover:underline">Shipping & Delivery</a></li>
                    <li><a href="#payment-faq" class="hover:underline">Payment Options</a></li>
                    <li><a href="#products-faq" class="hover:underline">Products & Personalization</a></li>
                </ul>
            </div>

            <!-- Terms & Conditions Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">Terms & Conditions</h3>
                <ul class="space-y-3">
                    <li><a href="#shipping-returns" class="hover:underline">Shipping & Returns</a></li>
                    <li><a href="#privacy-policy" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="#terms-conditions" class="hover:underline">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-white/30 my-8"></div>

        <!-- Copyright and Social Media -->
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <!-- make current time -->
                <p>&copy; {{ date('Y') }} Afro Jee</p>
            </div>

            <div class="flex space-x-4">
                <!-- WhatsApp Icon -->
                <a href="https://wa.me/+34602181565"
                    class="bg-white text-footergold rounded-full p-2 flex items-center justify-center w-10 h-10 hover:opacity-90 transition-opacity">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <!-- Instagram Icon -->
                <a href="https://www.instagram.com/afro_jeee/"
                    class="bg-white text-footergold rounded-full p-2 flex items-center justify-center w-10 h-10 hover:opacity-90 transition-opacity">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <!-- Snapchat Icon -->
                <!-- <a href="#"
                    class="bg-white text-footergold rounded-full p-2 flex items-center justify-center w-10 h-10 hover:opacity-90 transition-opacity">
                    <i class="fa-brands fa-snapchat"></i>
                </a> -->
            </div>
        </div>
    </div>
</footer>