<footer class="relative overflow-hidden bg-footergold text-white py-12">
    <div class="absolute inset-0">
        <div class="h-full w-full opacity-20 pointer-events-none"
            style="background-image: radial-gradient(rgba(255,255,255,0.35) 1px, transparent 1px); background-size: 28px 28px;">
        </div>
    </div>
    <div class="relative z-10 container mx-auto px-4 md:px-8">
        <!-- Logo Section -->
        <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:space-x-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="Afro Jee logo" class="w-24 h-auto mb-4 sm:mb-0 rounded-md object-contain">
            <h2 class="text-3xl font-bold text-white">AFRO JEE</h2>
        </div>

        <!-- Footer Navigation -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <!-- About Us Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">{{ __('common.footer.about_us') }}</h3>
                <ul class="space-y-3">
                    <li><a href="/about#our-mission" class="hover:underline">{{ __('common.footer.our_mission') }}</a></li>
                    <li><a href="/about#our-vision" class="hover:underline">{{ __('common.footer.our_vision') }}</a></li>
                    <li><a href="/about#our-coverage" class="hover:underline">{{ __('common.footer.our_coverage') }}</a></li>
                </ul>
            </div>

            <!-- FAQs Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">{{ __('common.footer.faqs') }}</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('web.questions') }}#shipping-faq" class="hover:underline">{{ __('common.footer.shipping_delivery') }}</a></li>
                    <li><a href="{{ route('web.questions') }}#payment-faq" class="hover:underline">{{ __('common.footer.payment_options') }}</a></li>
                    <li><a href="{{ route('web.questions') }}#products-faq" class="hover:underline">{{ __('common.footer.products_personalization') }}</a></li>
                    <li><a href="{{ route('web.questions') }}#shipping-returns-faq" class="hover:underline">{{ __('common.footer.shipping_returns') }}</a></li>
                </ul>
            </div>

            <!-- Terms & Conditions Column -->
            <div>
                <h3 class="text-xl font-medium mb-4">{{ __('common.footer.legal') }}</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('web.terms') }}" class="hover:underline">{{ __('common.footer.terms_conditions') }}</a></li>
                    <li><a href="{{ route('web.privacy') }}" class="hover:underline">{{ __('common.footer.privacy_policy') }}</a></li>
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