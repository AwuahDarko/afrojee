
<section class="swiper myHeroSwiper relative w-full h-screen overflow-hidden">
    <div class="swiper-wrapper">

        <!-- Slide 1: Circular Reveal -->
        <div class="swiper-slide relative w-full h-screen" data-transition="circle">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p1.jpeg') }}" alt="Beauty product with rose petals"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>

            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-up delay-100">
                        Beauty creams, oils, balms & more
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-right delay-200">
                        Together, <span class="font-bold">we celebrate<br class="hidden sm:block">natural beauty</span> in every curl<br
                            class="hidden sm:block">
                        <span class="font-bold">Beauty that unites us all</span>
                    </h1>
                    <div class="hidden hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up-fast delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            View Products
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn more
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-left delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Tamara Odoom"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"My skin has never felt this radiant"
                    </p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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

        <!-- Slide 2: Tiled Assembly -->
        <div class="swiper-slide relative w-full h-screen" data-transition="tiles">
            <div class="tile-overlay"></div>
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p2.jpeg') }}" alt="Beauty product with lavender"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-left delay-100">
                        Natural ingredients for glowing skin
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-up delay-200">
                        Discover <span class="font-bold">nature’s power<br class="hidden sm:block">for your healthy,</span> radiant<br
                            class="hidden sm:block">
                        <span class="font-bold"> hair</span>
                    </h1>
                    <div class="hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up-fast delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-right delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Sarah Johnson"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Sarah Johnson</span>
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"Transformed my skincare routine!"
                    </p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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

        <!-- Slide 3: Ball Drop -->
        <div class="swiper-slide relative w-full h-screen" data-transition="ball-drop">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p3.jpeg') }}" alt="Beauty product with aloe vera"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-up-fast delay-100">
                        Hydrate & nourish with aloe vera
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-left delay-200">
                        Embrace <span class="font-bold">deep nourishment<br class="hidden sm:block">for your </span> vibrant curls<br
                            class="hidden sm:block">
                        <span class="font-bold hidden">vibrant curls</span>
                    </h1>
                    <div class="hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Explore Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-right delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Emily Chen"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Emily Chen</span>
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"My skin feels so refreshed and
                        soft!"</p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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

        <!-- Slide 4: Sidebar Slide-In -->
        <div class="swiper-slide relative w-full h-screen" data-transition="sidebar">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p5.jpeg') }}" alt="Beauty product with chamomile"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-left delay-100">
                        Soothing chamomile for calm skin
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-up-fast delay-200">
                        From our hands <span class="font-bold">to your hair,<br class="hidden sm:block">pure care inside.</span> Every delivery, <br
                            class="hidden sm:block">
                        <span class="font-bold">a promise of beauty</span>
                    </h1>
                    <div class="hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Discover Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-left delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Lila Patel"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Lila Patel</span>
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"The best addition to my beauty
                        routine!"</p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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

        <!-- Slide 5: New - Slices Drop (Vertical slices dropping in) -->
        <div class="swiper-slide relative w-full h-screen" data-transition="slices-drop">
            <div class="slice-overlay"></div>
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p4.jpeg') }}" alt="Beauty product with essential oils"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-up delay-100">
                        Essential oils for ultimate relaxation
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-right delay-200">
                        Experience joy <span class="font-bold">and confidence<br class="hidden sm:block">in every</span> hair<br
                            class="hidden sm:block">
                        <span class="font-bold">routine</span>
                    </h1>
                    <div class="hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up-fast delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Shop Oils
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-left delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Mia Rodriguez"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Mia Rodriguez</span>
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"These oils changed my life!"</p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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

        <!-- Slide 6: New - Spin Reveal -->
        <!-- <div class="swiper-slide relative w-full h-screen" data-transition="spin">
            <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0" data-swiper-parallax-opacity="0.5"
                data-swiper-parallax="50%">
                <img src="{{ asset('images/p5.png') }}" alt="Beauty product with herbs"
                    class="w-full h-full object-cover transition-all duration-3000 ease-out" />
            </div>
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <div class="relative z-20 container mx-auto h-full px-4 sm:px-6 md:px-8 flex flex-col justify-center">
                <div class="max-w-2xl space-y-6">
                    <div
                        class="hero-label hidden  px-4 sm:px-6 py-2 rounded-full bg-gray-500/70 text-white text-xs sm:text-sm animate-slide-left delay-100">
                        Herbal remedies for natural beauty
                    </div>
                    <h1
                        class="hero-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-light text-white leading-tight animate-slide-up delay-200">
                        Unlock <span class="font-bold">herbal<br class="hidden sm:block">secrets</span> for timeless<br
                            class="hidden sm:block">
                        <span class="font-bold">beauty</span>
                    </h1>
                    <div class="hero-cta hidden flex flex-col sm:flex-row gap-3 sm:gap-4 animate-slide-up-fast delay-300">
                        <a href="/products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Browse Herbs
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#who-section"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors text-sm sm:text-base w-full sm:w-auto">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="hero-testimonial absolute hidden bottom-4 left-4 right-4 sm:bottom-8 sm:left-auto sm:right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-4 sm:p-6 max-w-xl text-white animate-slide-right delay-500">
                    <div class="flex items-center space-x-3 sm:space-x-4 mb-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex-shrink-0">
                            <img src="{{ asset('images/profile.png') }}" alt="Sophia Lee"
                                class="w-full h-full object-cover" />
                        </div>
                        <div
                            class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center text-xs sm:text-sm md:text-base min-w-0">
                            <span class="font-semibold sm:mr-2 truncate">Sophia Lee</span>
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
                    <p class="italic text-white mb-3 sm:mb-4 text-sm sm:text-base">"Natural beauty at its finest!"</p>
                    <a href="#"
                        class="inline-flex items-center text-white font-medium hover:underline text-sm sm:text-base">
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
        </div> -->
    </div>
    <div class="transition-overlay"></div>
    <!-- <div class="swiper-pagination"></div> -->
    <!-- <div class="swiper-button-prev text-primary hidden sm:block"></div> -->
    <!-- <div class="swiper-button-next text-primary hidden sm:block"></div> -->
</section>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- <style>
    /* --- Timing / delay classes kept for content staggering --- */
    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    .delay-500 {
        animation-delay: 0.5s;
    }

    /* --- Content animation keyframes (pure CSS) --- */
    .animate-slide-up,
    .animate-slide-up-fast,
    .animate-slide-right,
    .animate-slide-left {
        opacity: 0;
        transform: translateY(20px);
        animation-fill-mode: forwards;
        animation-timing-function: cubic-bezier(.2, .9, .3, 1);
    }

    .animate-slide-right {
        transform: translateX(-20px);
    }

    .animate-slide-left {
        transform: translateX(20px);
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slide-up {
        animation-name: slideUp;
        animation-duration: .8s;
    }

    .animate-slide-up-fast {
        animation-name: slideUp;
        animation-duration: .55s;
    }

    .animate-slide-right {
        animation-name: slideRight;
        animation-duration: .8s;
    }

    .animate-slide-left {
        animation-name: slideLeft;
        animation-duration: .8s;
    }

    /* burgundy color */
    .bg-burgundy {
        background-color: #800020;
    }

    /* Overlay / tile / slice styles tuned for performance */
    .tile-overlay,
    .slice-overlay {
        position: absolute;
        inset: 0;
        z-index: 15;
        pointer-events: none;
        will-change: opacity;
    }

    /* Tiles: horizontal pieces (use transform: scaleX to animate) */
    .tile-overlay {
        display: flex;
    }

    .tile-overlay .tile {
        flex: 1 1 0;
        transform-origin: left center;
        transform: scaleX(0);
        transition: transform .55s cubic-bezier(.2, .9, .3, 1), opacity .55s linear;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    /* Slices: vertical pieces sliding from top */
    .slice-overlay {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
    }

    .slice-overlay .slice {
        height: 100%;
        transform: translateY(-105%);
        transition: transform .55s cubic-bezier(.2, .9, .3, 1), opacity .55s linear;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    /* Circle reveal (uses clip-path) */
    .circle-reveal {
        clip-path: circle(0% at 50% 50%);
        transition: clip-path 0.9s cubic-bezier(.22, .9, .3, 1);
        will-change: clip-path;
    }

    .circle-reveal.active {
        clip-path: circle(120% at 50% 50%);
    }

    /* Ball drop (translateY only) */
    .ball-drop {
        transform: translateY(-100vh);
        transition: transform 1.05s cubic-bezier(.18, .9, .3, 1);
        will-change: transform;
    }

    .ball-drop.active {
        transform: translateY(0);
    }

    /* Sidebar slide */
    .sidebar-slide {
        transform: translateX(100%);
        transition: transform .7s cubic-bezier(.2, .9, .3, 1);
        will-change: transform;
    }

    .sidebar-slide.active {
        transform: translateX(0%);
    }

    /* Spin reveal */
    .spin-reveal {
        opacity: 0;
        transform: rotate(45deg) scale(.9);
        transition: transform .75s cubic-bezier(.2, .9, .3, 1), opacity .75s ease;
        will-change: transform, opacity;
    }

    .spin-reveal.active {
        opacity: 1;
        transform: rotate(0deg) scale(1);
    }

    /* Hide navigation on very small screens (kept) */
    .swiper-button-prev.hidden,
    .swiper-button-next.hidden {
        display: none;
    }

    /* reduce overlay visual workload after animation */
    .tile-overlay.hidden,
    .slice-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }

    /* small accessibility / smooth image transform */
    .myHeroSwiper img {
        backface-visibility: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* reduce heavy blur in case it causes re-paints - keep but beware on low-end devices */
    .hero-testimonial {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .transition-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #800020;
        /* burgundy overlay */
        z-index: 9999;
        transform: scaleY(0);
        transform-origin: top;
        opacity: 0;
        pointer-events: none;
    }

    .transition-overlay.active {
        animation: pageReveal 1s ease forwards;
    }

    @keyframes pageReveal {
        0% {
            transform: scaleY(0);
            opacity: 0;
            transform-origin: top;
        }

        25% {
            transform: scaleY(1);
            opacity: 1;
            transform-origin: top;
        }

        75% {
            transform: scaleY(1);
            opacity: 1;
            transform-origin: bottom;
        }

        100% {
            transform: scaleY(0);
            opacity: 0;
            transform-origin: bottom;
        }
    }
</style> -->

<style>
    /* ===== Universal transition overlay ===== */
.transition-overlay {
  /* position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: #800020;
  opacity: 0;
  transform: scaleY(0);
  transform-origin: top;
  pointer-events: none;
  z-index: 9999; */
}
.transition-overlay.active {
  animation: pageTransition 1s ease-in-out forwards;
}

@keyframes pageTransition {
  0% { transform: scaleY(0); opacity: 0; }
  25% { transform: scaleY(1); opacity: 1; }
  75% { transform: scaleY(1); opacity: 1; }
  100% { transform: scaleY(0); opacity: 0; transform-origin: bottom; }
}

/* ===== Individual slide animations ===== */

/* Circle Reveal */
@keyframes circleReveal {
  0% { clip-path: circle(0% at 50% 50%); }
  100% { clip-path: circle(150% at 50% 50%); }
}
[data-transition="circle"].animate-transition img {
  animation: circleReveal 1s ease forwards;
}

/* Tiled Assembly */
@keyframes tileReveal {
  0% { transform: scale(1.3) rotate(4deg); opacity: 0; }
  100% { transform: scale(1) rotate(0deg); opacity: 1; }
}
[data-transition="tiles"].animate-transition img {
  animation: tileReveal 0.9s cubic-bezier(.4,.8,.4,1) forwards;
}

/* Ball Drop */
@keyframes ballDrop {
  0% { transform: translateY(-120%) scale(1.2); opacity: 0; border-radius: 50%; }
  70% { transform: translateY(10%) scale(1); opacity: 1; border-radius: 30%; }
  100% { transform: translateY(0); border-radius: 0; }
}
[data-transition="ball-drop"].animate-transition img {
  animation: ballDrop 1.1s cubic-bezier(.3,1.3,.3,1) forwards;
}

/* Sidebar Slide-In */
@keyframes sidebarReveal {
  0% { clip-path: inset(0 100% 0 0); }
  100% { clip-path: inset(0 0 0 0); }
}
[data-transition="sidebar"].animate-transition img {
  animation: sidebarReveal 0.8s ease-in-out forwards;
}

/* Slices Drop */
@keyframes slicesDrop {
  0% { transform: perspective(600px) rotateX(-90deg); opacity: 0; }
  100% { transform: perspective(600px) rotateX(0); opacity: 1; }
}
[data-transition="slices-drop"].animate-transition img {
  animation: slicesDrop 1s cubic-bezier(.25,1,.3,1) forwards;
}

/* Spin Reveal */
@keyframes spinReveal {
  0% { transform: rotateY(180deg) scale(0.8); opacity: 0; }
  100% { transform: rotateY(0deg) scale(1); opacity: 1; }
}
[data-transition="spin"].animate-transition img {
  animation: spinReveal 1s cubic-bezier(.3,1,.3,1) forwards;
}

/* ===== Text + CTA Entrance Animations ===== */
.animate-text .hero-label hidden,
.animate-text .hero-heading,
.animate-text .hero-cta,
.animate-text .hero-testimonial {
  opacity: 0;
  transform: translateY(20px);
}
.animate-text.show .hero-label hidden {
  animation: fadeUp 0.6s ease-out forwards 0.1s;
}
.animate-text.show .hero-heading {
  animation: fadeUp 0.6s ease-out forwards 0.25s;
}
.animate-text.show .hero-cta {
  animation: fadeUp 0.6s ease-out forwards 0.4s;
}
.animate-text.show .hero-testimonial {
  animation: fadeUp 0.6s ease-out forwards 0.55s;
}
@keyframes fadeUp {
  to { opacity: 1; transform: translateY(0); }
}

</style>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const swiper = new Swiper(".myHeroSwiper", {
    loop: true,
    speed: 900,
    autoplay: { delay: 5000, disableOnInteraction: false },
    effect: "slide",
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    on: {
      slideChangeTransitionStart: function () {
        const overlay = document.querySelector(".transition-overlay");
        overlay.classList.add("active");

        // Get the incoming active slide
        const nextSlide = this.slides[this.activeIndex];
        const prevSlide = this.slides[this.previousIndex];

        // reset previous
        prevSlide.classList.remove("animate-transition");
        prevSlide.querySelector(".hero-content")?.classList.remove("show");

        // animate incoming
        setTimeout(() => {
          nextSlide.classList.add("animate-transition");
          nextSlide.querySelector(".hero-content")?.classList.add("animate-text", "show");
        }, 400);

        // remove overlay after animation
        setTimeout(() => overlay.classList.remove("active"), 1000);
      },
      init: function () {
        const firstSlide = this.slides[this.activeIndex];
        firstSlide.classList.add("animate-transition");
        firstSlide.querySelector(".hero-content")?.classList.add("animate-text", "show");
      }
    }
  });
});
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const overlay = document.querySelector('.transition-overlay');

        const swiper = new Swiper('.myHeroSwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'creative',
            creativeEffect: {
                prev: { shadow: true, translate: [0, 0, -400] },
                next: { translate: ['100%', 0, 0] },
            },
            parallax: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                init: function () {
                    // Initialize overlays for tiles & slices
                    document.querySelectorAll('[data-transition="tiles"]').forEach(slide => {
                        const overlay = slide.querySelector('.tile-overlay');
                        for (let i = 0; i < 5; i++) {
                            const tile = document.createElement('div');
                            tile.classList.add('tile');
                            overlay.appendChild(tile);
                        }
                    });

                    document.querySelectorAll('[data-transition="slices-drop"]').forEach(slide => {
                        const overlay = slide.querySelector('.slice-overlay');
                        for (let i = 0; i < 5; i++) {
                            const slice = document.createElement('div');
                            slice.classList.add('slice');
                            overlay.appendChild(slice);
                        }
                    });
                },

                slideChangeTransitionStart: function () {
                    // 🔥 Trigger overlay animation between slides
                    overlay.classList.add('active');
                    setTimeout(() => overlay.classList.remove('active'), 1000);

                    // Reset slide animations
                    this.slides.forEach(slide => {
                        const elements = slide.querySelectorAll('[class*="animate-"]');
                        elements.forEach(el => {
                            el.style.animation = 'none';
                        });
                        slide.classList.remove('circle-reveal', 'ball-drop', 'sidebar-slide', 'spin-reveal', 'active');

                        const tiles = slide.querySelectorAll('.tile-overlay .tile');
                        tiles.forEach(tile => {
                            tile.style.transform = 'scaleX(0)';
                            tile.style.opacity = '1';
                        });
                        const slices = slide.querySelectorAll('.slice-overlay .slice');
                        slices.forEach(slice => {
                            slice.style.transform = 'translateY(-100%)';
                            slice.style.opacity = '1';
                        });
                    });
                },

                slideChangeTransitionEnd: function () {
                    const activeSlide = this.slides[this.activeIndex];
                    const transitionType = activeSlide.dataset.transition;

                    // Re-trigger animations
                    const elements = activeSlide.querySelectorAll('[class*="animate-"]');
                    elements.forEach(el => {
                        void el.offsetWidth;
                        const classes = el.getAttribute('class');
                        const animationClasses = classes.match(/animate-[\w-]+/g)?.join(' ') || '';
                        const delayClasses = classes.match(/delay-\d+/g)?.join(' ') || '';
                        const duration = animationClasses.includes('fast') ? '0.6s' : '0.8s';
                        el.style.animation = `${animationClasses.split(' ')[0]} ${duration} ease-out forwards ${delayClasses.split(' ')[0] || '0s'}`;
                    });

                    // Apply per-slide transitions
                    if (transitionType === 'circle') activeSlide.classList.add('circle-reveal', 'active');
                    else if (transitionType === 'tiles') {
                        const tiles = activeSlide.querySelectorAll('.tile-overlay .tile');
                        tiles.forEach((tile, i) => setTimeout(() => {
                            tile.style.transform = 'scaleX(1)';
                            tile.style.transitionDelay = `${i * 0.2}s`;
                        }, 100));
                        setTimeout(() => activeSlide.querySelector('.tile-overlay').style.opacity = '0', 1500);
                    } else if (transitionType === 'ball-drop') activeSlide.classList.add('ball-drop', 'active');
                    else if (transitionType === 'sidebar') activeSlide.classList.add('sidebar-slide', 'active');
                    else if (transitionType === 'slices-drop') {
                        const slices = activeSlide.querySelectorAll('.slice-overlay .slice');
                        slices.forEach((slice, i) => setTimeout(() => {
                            slice.style.transform = 'translateY(0)';
                            slice.style.transitionDelay = `${i * 0.2}s`;
                        }, 100));
                        setTimeout(() => activeSlide.querySelector('.slice-overlay').style.opacity = '0', 1500);
                    } else if (transitionType === 'spin') activeSlide.classList.add('spin-reveal', 'active');
                }
            }
        });

        // Initial load trigger
        setTimeout(() => {
            const initialSlide = swiper.slides[swiper.activeIndex];
            const transitionType = initialSlide.dataset.transition;
            if (transitionType === 'circle') initialSlide.classList.add('circle-reveal', 'active');
            else if (transitionType === 'tiles') {
                const tiles = initialSlide.querySelectorAll('.tile-overlay .tile');
                tiles.forEach((tile, i) => setTimeout(() => {
                    tile.style.transform = 'scaleX(1)';
                    tile.style.transitionDelay = `${i * 0.2}s`;
                }, 100));
                setTimeout(() => initialSlide.querySelector('.tile-overlay').style.opacity = '0', 1500);
            } else if (transitionType === 'ball-drop') initialSlide.classList.add('ball-drop', 'active');
            else if (transitionType === 'sidebar') initialSlide.classList.add('sidebar-slide', 'active');
            else if (transitionType === 'slices-drop') {
                const slices = initialSlide.querySelectorAll('.slice-overlay .slice');
                slices.forEach((slice, i) => setTimeout(() => {
                    slice.style.transform = 'translateY(0)';
                    slice.style.transitionDelay = `${i * 0.2}s`;
                }, 100));
                setTimeout(() => initialSlide.querySelector('.slice-overlay').style.opacity = '0', 1500);
            } else if (transitionType === 'spin') initialSlide.classList.add('spin-reveal', 'active');
        }, 100);
    });
</script> -->