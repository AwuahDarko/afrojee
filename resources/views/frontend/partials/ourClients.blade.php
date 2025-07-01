<!-- This is a Blade template section that should be saved as a .blade.php file -->
<section class="bg-pink-50">
    <div class="container mx-auto px-4 py-25">
        <div class="mb-16">
            <div class="flex flex-col md:flex-row items-center">
                <h1 class="text-5xl min-w-[26%] font-medium text-rose-700">
                    <span class="block">What Our</span>
                    <span class="text-rose-700 font-bold text-5xl w-full">Clients Say?</span>
                </h1>
                <div class="w-full h-1 bg-rose-300 mt-4 md:mt-0"></div>
            </div>
        </div>

        @if($featuredReviews->count() > 0)
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Content - Testimonials -->
            <div class="lg:w-3/4 relative">
                <!-- Testimonial Slides -->
                <div class="testimonial-container relative">
                    @foreach($featuredReviews as $index => $review)
                    <div class="testimonial-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-800 mb-4">"{{ $review->review }}"</p>

                            <div class="flex items-center mt-6">
                                <div class="w-12 h-12 bg-rose-100 rounded-full overflow-hidden border-2 border-rose-500">
                                    @if($review->image)
                                        <img src="{{ asset('storage/reviews/' . $review->image) }}" 
                                             alt="{{ $review->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-rose-200 flex items-center justify-center">
                                            <span class="text-rose-600 font-bold text-lg">
                                                {{ strtoupper(substr($review->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="flex text-yellow-400 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="font-medium text-gray-700">{{ $review->name }}</p>
                                    @if($review->product_name)
                                        <p class="text-sm text-gray-500">{{ $review->product_name }} User</p>
                                    @endif
                                    @if($review->title)
                                        <p class="text-sm text-rose-600 font-medium">{{ $review->title }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($featuredReviews->count() > 1)
                <!-- Navigation Arrows -->
                <div class="flex mt-4">
                    <button id="prev-btn"
                        class="w-12 h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="next-btn"
                        class="w-12 h-12 flex items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition ml-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <div class="ml-auto">
                        <a href="{{ route('reviews.all') }}" class="text-rose-700 font-medium flex items-center hover:underline">
                            View All Reviews
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            @if($featuredReviews->count() > 1)
            <!-- Right Content - Client List -->
            <div class="lg:w-1/4 mt-12 lg:mt-1">
                <div class="space-y-6">
                    @foreach($featuredReviews as $index => $review)
                    <div class="flex items-center cursor-pointer client-nav {{ $index === 0 ? '' : 'opacity-50' }}" data-index="{{ $index }}">
                        <div class="w-10 h-10 bg-rose-100 rounded-full overflow-hidden border-2 {{ $index === 0 ? 'border-rose-500' : 'border-gray-300' }}">
                            @if($review->image)
                                <img src="{{ asset('storage/reviews/' . $review->image) }}" 
                                     alt="{{ $review->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-rose-200 flex items-center justify-center">
                                    <span class="text-rose-600 font-bold text-sm">
                                        {{ strtoupper(substr($review->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <p class="ml-4 font-medium {{ $index === 0 ? 'text-gray-700' : 'text-gray-500' }}">{{ $review->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @else
        <!-- No Featured Reviews -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-4 bg-rose-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-medium text-gray-700 mb-2">No Featured Reviews Yet</h3>
            <p class="text-gray-500">Featured customer reviews will appear here once they're available.</p>
        </div>
        @endif
    </div>

    @if($featuredReviews->count() > 1)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Variables
            const slides = document.querySelectorAll('.testimonial-slide');
            const clientNavs = document.querySelectorAll('.client-nav');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentIndex = 0;
            const totalSlides = slides.length;

            // Initialize
            updateSlide();

            // Event listeners
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                    updateSlide();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateSlide();
                });
            }

            clientNavs.forEach(nav => {
                nav.addEventListener('click', () => {
                    currentIndex = parseInt(nav.getAttribute('data-index'));
                    updateSlide();
                });
            });

            // Functions
            function updateSlide() {
                // Update slides
                slides.forEach(slide => {
                    slide.classList.remove('active');
                });
                if (slides[currentIndex]) {
                    slides[currentIndex].classList.add('active');
                }

                // Update client navs
                clientNavs.forEach(nav => {
                    const navIndex = parseInt(nav.getAttribute('data-index'));
                    if (navIndex === currentIndex) {
                        nav.classList.remove('opacity-50');
                        nav.querySelector('.w-10').classList.remove('border-gray-300');
                        nav.querySelector('.w-10').classList.add('border-rose-500');
                        nav.querySelector('p').classList.remove('text-gray-500');
                        nav.querySelector('p').classList.add('text-gray-700');
                    } else {
                        nav.classList.add('opacity-50');
                        nav.querySelector('.w-10').classList.remove('border-rose-500');
                        nav.querySelector('.w-10').classList.add('border-gray-300');
                        nav.querySelector('p').classList.remove('text-gray-700');
                        nav.querySelector('p').classList.add('text-gray-500');
                    }
                });
            }

            // Auto-rotate slides every 7 seconds (increased for better UX)
            if (totalSlides > 1) {
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateSlide();
                }, 7000);
            }
        });
    </script>
    @endif

    <style>
        .testimonial-slide {
            display: none;
        }
        .testimonial-slide.active {
            display: block;
        }
    </style>
</section>
