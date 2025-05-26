
<!-- Hero Section -->
<section class="relative w-full h-screen overflow-hidden">
    <!-- Background Image (placeholder in this case) -->
    <div class="absolute inset-0 w-full h-full bg-cover bg-center z-0">
        <img src="{{ asset('images/1.png') }}" alt="Beauty product with rose petals"
            class="w-full h-full object-cover" />
    </div>

    <!-- Overlay for better text readability -->
    <div class="absolute inset-0 bg-black/10 z-10"></div>

    <!-- Content Container -->
    <div class="relative z-20 container mx-auto h-full px-4 md:px-8 flex flex-col justify-center">
        <div class="max-w-2xl">
            <!-- Product Category Label -->
            <div class="hero-label inline-block px-6 py-2 rounded-full bg-gray-500/70 text-white text-sm mb-6">
                Beauty creams, oils, balms & more
            </div>

            <!-- Main Heading -->
            <h1 class="hero-heading text-5xl md:text-6xl lg:text-7xl font-light text-white leading-tight mb-4">
                Curated <span class="font-bold">beauty<br>essentials</span> for your<br>
                <span class="font-bold">unique lifestyle</span>
            </h1>

            <!-- Call to Action Buttons -->
            <div class="hero-cta flex flex-wrap gap-4 mt-8">
                <a href="#"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-burgundy text-white hover:bg-burgundy/90 transition-colors">
                    Buy Now
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-full border-2 border-white text-white hover:bg-white/10 transition-colors">
                    Learn more
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Testimonial Card -->
        <div
            class="hero-testimonial absolute bottom-8 right-8 md:right-16 bg-gray-800/80 backdrop-blur-sm rounded-lg p-6 max-w-xl text-white">
            <!-- Top Row: Avatar + Name + Divider + Stars -->
            <div class="flex items-center space-x-4 mb-2">
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full overflow-hidden">
                    <img src="{{ asset('images/profile.png') }}" alt="Tamara Odoom"
                        class="w-full h-full object-cover" />
                </div>

                <!-- Name and Stars -->
                <div class="flex flex-wrap items-center text-sm md:text-base">
                    <span class="font-semibold mr-2">Tamara Odoom</span>
                    <span class="text-white/50 mx-1">|</span>
                    <div class="flex text-yellow-400 ml-2 space-x-1">
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Quote -->
            <p class="italic text-white mb-4">“My skin has never felt this radiant”</p>

            <!-- All Reviews Link -->
            <a href="#" class="inline-flex items-center text-white font-medium hover:underline">
                All reviews
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>

    </div>
</section>