<section class="swiper myHeroSwiper relative w-full h-screen overflow-hidden">
    <div class="swiper-wrapper">
        <div class="swiper-slide relative w-full h-screen">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0">
                <img src="{{ asset('images/p4.jpg') }}" alt="Beauty product with rose petals"
                    class="w-full h-full object-cover" />
            </div>

            <div class="absolute inset-0 bg-black/10 z-10"></div>

            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl">
                    <!-- Hero Label -->
                    <div class="hero-label inline-block px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm mb-4 sm:mb-6">
                        Beauty creams, oils, balms & more
                    </div>

                    <!-- Hero Heading -->
                    <h1 class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight mb-4 sm:mb-6">
                        Curated <span class="font-bold">beauty<br class="hidden sm:block">essentials</span> for your<br class="hidden sm:block">
                        <span class="font-bold">unique lifestyle</span>
                    </h1>

                    <!-- CTA Buttons -->
                    <div class="hero-cta flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            View Products
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Testimonial - Repositioned for mobile -->
                <div class="hero-testimonial absolute bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Tamara Odoom"
                                class="w-full h-full object-cover" />
                        </div>

                        <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Tamara Odoom</span>
                            <span class="text-white/50 mx-1 hidden sm:inline">|</span>
                            <div class="flex text-yellow-400 sm:ml-2 space-x-1 mt-1 sm:mt-0">
                                <i class="fas fa-star text-xs sm:text-sm"></i>
                                <i class="fas fa-star text-xs sm:text-sm"></i>
                                <i class="fas fa-star text-xs sm:text-sm"></i>
                                <i class="fas fa-star text-xs sm:text-sm"></i>
                                <i class="fas fa-star text-xs sm:text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"My skin has never felt this radiant"</p>

                    <a href="#" class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
                        All reviews
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper Controls -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev hidden sm:block"></div>
    <div class="swiper-button-next hidden sm:block"></div>
</section>
