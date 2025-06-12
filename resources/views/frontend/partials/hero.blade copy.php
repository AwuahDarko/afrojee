
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(1.1);
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .slide.prev {
            transform: translateX(-100%) scale(0.9);
        }

        .slide.next {
            transform: translateX(100%) scale(0.9);
        }

        .slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .slide-1 .slide-bg {
            background-image: url('images/p4.jpg');
        }

        .slide-2 .slide-bg {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .slide-3 .slide-bg {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .slide-4 .slide-bg {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(1px);
        }

        .slide-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .content-wrapper {
            max-width: 800px;
            color: white;
            transform: translateY(50px);
            opacity: 0;
            transition: all 1s ease-out 0.3s;
        }

        .slide.active .content-wrapper {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-label {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease-out 0.5s;
        }

        .slide.active .slide-label {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-title {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 300;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            transform: translateY(40px);
            opacity: 0;
            transition: all 1s ease-out 0.7s;
        }

        .slide.active .slide-title {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-title .bold {
            font-weight: 700;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .slide-description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            opacity: 0.9;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease-out 0.9s;
        }

        .slide.active .slide-description {
            transform: translateY(0);
            opacity: 0.9;
        }

        .slide-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            transform: translateY(40px);
            opacity: 0;
            transition: all 1s ease-out 1.1s;
        }

        .slide.active .slide-buttons {
            transform: translateY(0);
            opacity: 1;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border: 2px solid rgba(255, 255, 255, 0.9);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .testimonial {
            position: absolute;
            bottom: 2rem;
            right: 2rem;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 1.5rem;
            max-width: 400px;
            color: white;
            transform: translateX(100px);
            opacity: 0;
            transition: all 1s ease-out 1.3s;
        }

        .slide.active .testimonial {
            transform: translateX(0);
            opacity: 1;
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .testimonial-info h4 {
            margin: 0;
            font-size: 1rem;
        }

        .testimonial-stars {
            color: #ffd700;
            font-size: 0.9rem;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .navigation {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            z-index: 20;
        }

        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-dot.active {
            background: white;
            transform: scale(1.2);
        }

        .nav-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            z-index: 20;
        }

        .nav-arrows:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .nav-prev {
            left: 2rem;
        }

        .nav-next {
            right: 2rem;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-element:nth-child(3) {
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @media (max-width: 768px) {
            .slide-content {
                padding: 1rem;
            }

            .testimonial {
                position: relative;
                right: auto;
                bottom: auto;
                margin-top: 2rem;
                max-width: 100%;
            }

            .nav-arrows {
                display: none;
            }

            .slide-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>

    <div class="slider-container">
        <!-- Slide 1 - Skincare -->
        <div class="slide active">
            <div class="slide-bg"></div>
            <div class="slide-overlay"></div>
            <div class="floating-elements">
                <div class="floating-element" style="top: 20%; left: 10%; font-size: 2rem;">✨</div>
                <div class="floating-element" style="top: 60%; right: 15%; font-size: 1.5rem;">🌸</div>
                <div class="floating-element" style="top: 30%; right: 30%; font-size: 1.8rem;">💎</div>
            </div>
            <div class="slide-content">
                <div class="content-wrapper">
                    <div class="slide-label">Premium Skincare Collection</div>
                    <h1 class="slide-title">
                        Radiant <span class="bold">Skin<br>Transformation</span>
                    </h1>
                    <p class="slide-description">
                        Discover our luxurious skincare range crafted with natural ingredients. 
                        Experience the difference with products designed to nourish, protect, and revitalize your skin.
                    </p>
                    <div class="slide-buttons">
                        <a href="#" class="btn btn-primary">
                            Shop Skincare
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="btn btn-secondary">
                            Learn More
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">S</div>
                    <div class="testimonial-info">
                        <h4>Sarah Mitchell</h4>
                        <div class="testimonial-stars">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"My skin has never looked better! The glow is incredible."</p>
                <a href="#" style="color: #ffd700; text-decoration: none; font-size: 0.9rem;">View all reviews →</a>
            </div>
        </div>

        <!-- Slide 2 - Hair Care -->
        <div class="slide">
            <div class="slide-bg"></div>
            <div class="slide-overlay"></div>
            <div class="floating-elements">
                <div class="floating-element" style="top: 15%; left: 20%; font-size: 2rem;">🌺</div>
                <div class="floating-element" style="top: 70%; right: 10%; font-size: 1.5rem;">✨</div>
                <div class="floating-element" style="top: 40%; right: 25%; font-size: 1.8rem;">🦋</div>
            </div>
            <div class="slide-content">
                <div class="content-wrapper">
                    <div class="slide-label">Professional Hair Care</div>
                    <h1 class="slide-title">
                        Stunning <span class="bold">Hair<br>Revolution</span>
                    </h1>
                    <p class="slide-description">
                        Transform your hair with our salon-quality products. From nourishing shampoos to revitalizing treatments, 
                        achieve the healthy, gorgeous hair you've always dreamed of.
                    </p>
                    <div class="slide-buttons">
                        <a href="#" class="btn btn-primary">
                            Hair Products
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="btn btn-secondary">
                            Hair Quiz
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">M</div>
                    <div class="testimonial-info">
                        <h4>Maya Rodriguez</h4>
                        <div class="testimonial-stars">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"My hair feels silky smooth and looks absolutely stunning!"</p>
                <a href="#" style="color: #ffd700; text-decoration: none; font-size: 0.9rem;">View all reviews →</a>
            </div>
        </div>

        <!-- Slide 3 - Wellness -->
        <div class="slide">
            <div class="slide-bg"></div>
            <div class="slide-overlay"></div>
            <div class="floating-elements">
                <div class="floating-element" style="top: 25%; left: 15%; font-size: 2rem;">🌿</div>
                <div class="floating-element" style="top: 65%; right: 20%; font-size: 1.5rem;">🕯️</div>
                <div class="floating-element" style="top: 35%; right: 35%; font-size: 1.8rem;">🧘‍♀️</div>
            </div>
            <div class="slide-content">
                <div class="content-wrapper">
                    <div class="slide-label">Wellness & Self-Care</div>
                    <h1 class="slide-title">
                        Complete <span class="bold">Wellness<br>Journey</span>
                    </h1>
                    <p class="slide-description">
                        Embrace holistic beauty with our wellness collection. From aromatherapy oils to relaxing bath essentials, 
                        create your perfect self-care routine for mind, body, and soul.
                    </p>
                    <div class="slide-buttons">
                        <a href="#" class="btn btn-primary">
                            Wellness Shop
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="btn btn-secondary">
                            Self-Care Guide
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">A</div>
                    <div class="testimonial-info">
                        <h4>Ava Thompson</h4>
                        <div class="testimonial-stars">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"The perfect way to unwind and pamper myself every day."</p>
                <a href="#" style="color: #ffd700; text-decoration: none; font-size: 0.9rem;">View all reviews →</a>
            </div>
        </div>

        <!-- Slide 4 - Makeup -->
        <div class="slide">
            <div class="slide-bg"></div>
            <div class="slide-overlay"></div>
            <div class="floating-elements">
                <div class="floating-element" style="top: 20%; left: 25%; font-size: 2rem;">💄</div>
                <div class="floating-element" style="top: 60%; right: 15%; font-size: 1.5rem;">✨</div>
                <div class="floating-element" style="top: 30%; right: 30%; font-size: 1.8rem;">👑</div>
            </div>
            <div class="slide-content">
                <div class="content-wrapper">
                    <div class="slide-label">Premium Makeup Collection</div>
                    <h1 class="slide-title">
                        Flawless <span class="bold">Beauty<br>Expression</span>
                    </h1>
                    <p class="slide-description">
                        Express your unique style with our curated makeup collection. From bold statement looks to natural everyday beauty, 
                        find everything you need to create your signature look.
                    </p>
                    <div class="slide-buttons">
                        <a href="#" class="btn btn-primary">
                            Shop Makeup
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="btn btn-secondary">
                            Tutorials
                            <i class="fas fa-chevron-down"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">L</div>
                    <div class="testimonial-info">
                        <h4>Luna Chen</h4>
                        <div class="testimonial-stars">★★★★★</div>
                    </div>
                </div>
                <p class="testimonial-text">"Colors that pop and quality that lasts all day long!"</p>
                <a href="#" style="color: #ffd700; text-decoration: none; font-size: 0.9rem;">View all reviews →</a>
            </div>
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <div class="nav-dot active" data-slide="0"></div>
            <div class="nav-dot" data-slide="1"></div>
            <div class="nav-dot" data-slide="2"></div>
            <div class="nav-dot" data-slide="3"></div>
        </div>

        <button class="nav-arrows nav-prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="nav-arrows nav-next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <script>
        class BeautySlider {
            constructor() {
                this.currentSlide = 0;
                this.slides = document.querySelectorAll('.slide');
                this.dots = document.querySelectorAll('.nav-dot');
                this.prevBtn = document.querySelector('.nav-prev');
                this.nextBtn = document.querySelector('.nav-next');
                this.totalSlides = this.slides.length;
                this.autoPlayInterval = null;
                
                this.init();
            }

            init() {
                this.bindEvents();
                this.startAutoPlay();
            }

            bindEvents() {
                // Navigation dots
                this.dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        this.goToSlide(index);
                        this.resetAutoPlay();
                    });
                });

                // Arrow buttons
                this.prevBtn.addEventListener('click', () => {
                    this.prevSlide();
                    this.resetAutoPlay();
                });

                this.nextBtn.addEventListener('click', () => {
                    this.nextSlide();
                    this.resetAutoPlay();
                });

                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        this.prevSlide();
                        this.resetAutoPlay();
                    } else if (e.key === 'ArrowRight') {
                        this.nextSlide();
                        this.resetAutoPlay();
                    }
                });

                // Pause on hover
                const container = document.querySelector('.slider-container');
                container.addEventListener('mouseenter', () => this.stopAutoPlay());
                container.addEventListener('mouseleave', () => this.startAutoPlay());

                // Touch/swipe support
                let startX = 0;
                let endX = 0;

                container.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                });

                container.addEventListener('touchend', (e) => {
                    endX = e.changedTouches[0].clientX;
                    this.handleSwipe();
                });

                container.addEventListener('mousedown', (e) => {
                    startX = e.clientX;
                    container.addEventListener('mouseup', handleMouseUp);
                });

                const handleMouseUp = (e) => {
                    endX = e.clientX;
                    this.handleSwipe();
                    container.removeEventListener('mouseup', handleMouseUp);
                };
            }

            handleSwipe() {
                const threshold = 50;
                const diff = startX - endX;

                if (Math.abs(diff) > threshold) {
                    if (diff > 0) {
                        this.nextSlide();
                    } else {
                        this.prevSlide();
                    }
                    this.resetAutoPlay();
                }
            }

            goToSlide(index) {
                // Remove active classes
                this.slides[this.currentSlide].classList.remove('active');
                this.dots[this.currentSlide].classList.remove('active');

                // Update current slide
                this.currentSlide = index;

                // Add active classes
                this.slides[this.currentSlide].classList.add('active');
                this.dots[this.currentSlide].classList.add('active');

                // Add entrance animation
                this.animateSlideEntry();
            }

            nextSlide() {
                const nextIndex = (this.currentSlide + 1) % this.totalSlides;
                this.goToSlide(nextIndex);
            }

            prevSlide() {
                const prevIndex = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
                this.goToSlide(prevIndex);
            }

            animateSlideEntry() {
                const activeSlide = this.slides[this.currentSlide];
                const elements = activeSlide.querySelectorAll('.slide-label, .slide-title, .slide-description, .slide-buttons, .testimonial');
                
                elements.forEach((element, index) => {
                    element.style.transform = 'translateY(50px)';
                    element.style.opacity = '0';
                    
                    setTimeout(() => {
                        element.style.transform = 'translateY(0)';
                        element.style.opacity = '1';
                    }, index * 100 + 300);
                });
            }

            startAutoPlay() {
                this.autoPlayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000); // Change slide every 5 seconds
            }

            stopAutoPlay() {
                if (this.autoPlayInterval) {
                    clearInterval(this.autoPlayInterval);
                    this.autoPlayInterval = null;
                }
            }

            resetAutoPlay() {
                this.stopAutoPlay();
                this.startAutoPlay();
            }
        }

        // Initialize slider when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new BeautySlider();
        });

        // Add some extra visual effects
        function createFloatingParticles() {
            const container = document.querySelector('.slider-container');
            const particles = ['✨', '🌸', '💎', '🌺', '🦋', '🌿', '💄', '👑'];
            
            setInterval(() => {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.fontSize = Math.random() * 20 + 10 + 'px';
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = '100%';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '5';
                particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                
                container.appendChild(particle);
                
                const animation = particle.animate([
                    { transform: 'translateY(0) rotate(0deg)', opacity: particle.style.opacity },
                    { transform: `translateY(-100vh) rotate(360deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 3000 + 2000,
                    easing: 'ease-out'
                });
                
                animation.addEventListener('finish', () => {
                    particle.remove();
                });
            }, 2000);
        }

        // Start particle animation
        setTimeout(createFloatingParticles, 1000);
    </script>
