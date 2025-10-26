@extends('frontend.layouts.app')

@section('title', 'About Us | Afro Jee')

@section('head')
    {{-- Custom Meta Tags for Sharing --}}
    <meta name="description"
        content="Discover Afro Jee's story - founded in Barcelona by Jennifer Pokuaa Effah to celebrate natural beauty with handmade, authentic hair care products.">
    <meta name="keywords"
        content="Afro Jee, about us, natural hair care, handmade products, Barcelona, Jennifer Pokuaa Effah">

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@AfroJee" />
    <meta name="twitter:image" content="{{ asset('images/about-share.jpg') }}" />

    <meta property="og:title" content="About Afro Jee - Your Beauty, Your Confidence" />
    <meta property="og:site_name" content="Afro Jee" />
    <meta property="og:url" content="{{ url('/about-us') }}" />
    <meta property="og:description"
        content="Born from passion in Barcelona, Afro Jee celebrates natural beauty with handmade, authentic hair care products." />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ asset('images/about-share.jpg') }}" />
@endsection


@section('content')

    <!-- Hero Section -->
    <section class="bg-[#F8F7F4] py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Side - Text -->
                <div class="order-2 lg:order-1">
                    <p class="text-sm tracking-[0.2em] text-gray-500 uppercase mb-4">Introducing</p>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-light mb-8">
                        About Afro Jee
                    </h1>
                    <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                        <p>
                            <strong class="text-gray-900">Afro Jee</strong> was born from the desire to celebrate and care
                            for natural beauty in all its forms. The name <em>Jee</em> comes from <em>Jenny</em>,
                            symbolizing dedication, creativity, and authenticity — a brand built from love, experience, and
                            identity.
                        </p>
                        <p>
                            Founded in <strong class="text-gray-900">2021</strong> in <strong
                                class="text-gray-900">Barcelona, Spain</strong>, by <strong class="text-gray-900">Jennifer
                                Pokuaa Effah</strong>, a proud Ghanaian entrepreneur, Afro Jee began as a personal dream
                            inspired by her lifelong passion for haircare and natural products.
                        </p>
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="order-1 lg:order-2 relative">
                    <img src="{{ asset('images/founder-jennifer.jpeg') }}" alt="Afro Jee Natural Hair Products"
                        class="w-full h-auto rounded-lg shadow-sm">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="bg-white py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto text-center">
            <!-- Decorative Element -->
            <div class="flex justify-center mb-8">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" class="text-gray-300">
                    <path
                        d="M30 5C16.2 5 5 16.2 5 30s11.2 25 25 25 25-11.2 25-25S43.8 5 30 5zm0 45c-11 0-20-9-20-20s9-20 20-20 20 9 20 20-9 20-20 20z"
                        fill="currentColor" opacity="0.3" />
                    <circle cx="30" cy="30" r="8" fill="currentColor" />
                </svg>
            </div>

            <h2 class="text-4xl md:text-5xl font-light mb-6 text-gray-900">
                We strive to live with compassion,<br>
                <span class="font-normal">kindness and empathy</span>
            </h2>

            <p class="text-gray-500 max-w-3xl mx-auto leading-relaxed text-lg">
                At Afro Jee, we don't just create hair products — we create confidence, care, and connection. Our journey
                started with a simple idea: to offer high-quality, handmade products that help people care for their natural
                hair with pride and joy.
            </p>
        </div>
    </section>

    <!-- Mission Section with Image -->
    <section class="bg-white py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Side - Image -->
                <div class="relative">
                    <img src="{{ asset('images/afro-jee-products.jpeg') }}" alt="Jennifer Pokuaa Effah - Founder"
                        class="w-full h-auto rounded-lg shadow-sm">
                </div>

                <!-- Right Side - Text -->
                <div>
                    <h2 class="text-4xl md:text-5xl font-light mb-6 text-gray-900">
                        Give your hair a healthy<br>
                        <span class="font-normal">glow everyone</span>
                    </h2>
                    <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                        <p>
                            Our mission at <strong class="text-gray-900">Afro Jee</strong> is to empower people to embrace
                            and love their natural hair by providing nourishing, authentic, and effective products. We
                            believe that every curl, coil, and texture deserves care, respect, and celebration.
                        </p>
                        <p>
                            We are committed to offering handmade, high-quality products that promote hair health,
                            confidence, and self-love. But our purpose goes far beyond selling — we aim to educate, guide,
                            and inspire through every product we create and every person we reach.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Section with Products -->
    <section class="bg-[#F8F7F4] py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left Side - Text -->
                <div>
                    <h2 class="text-4xl md:text-5xl font-light mb-6 text-gray-900">
                        Our mission
                    </h2>
                    <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                        <p>
                            <strong class="text-gray-900">Our vision</strong> at Afro Jee is to become a trusted and
                            recognized global brand that celebrates natural beauty, culture, and identity. We aspire to
                            expand our community internationally while maintaining the same handmade quality, care, and
                            authenticity that define us.
                        </p>
                        <p>
                            But our vision goes beyond haircare. Through Afro Jee, we want to inspire, educate, and empower
                            — helping people feel proud of who they are, where they come from, and how they express
                            themselves.
                        </p>
                    </div>
                </div>

                <!-- Right Side - Products Image -->
                <div class="relative">
                    <img src="{{ asset('images/afro-jee-products.jpeg') }}" alt="Afro Jee Product Range"
                        class="w-full h-auto rounded-lg shadow-sm">
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Section -->
    <section class="bg-white py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto text-center">
            <!-- Decorative Element -->
            <div class="flex justify-center mb-8">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" class="text-gray-300">
                    <path d="M20 15l10 10-10 10M30 15l10 10-10 10" stroke="currentColor" stroke-width="2" fill="none"
                        opacity="0.3" />
                </svg>
            </div>

            <h2 class="text-3xl md:text-4xl font-light mb-6 text-gray-900">About The Founder</h2>

            <div class="max-w-4xl mx-auto space-y-6 text-gray-600 text-lg leading-relaxed">
                <p>
                    <strong class="text-gray-900">Jennifer Pokuaa Effah</strong> is a young Psychology graduate with a
                    Master's degree in Occupational Risk Prevention, passionate about personal growth, continuous learning,
                    and the overall well-being of people.
                </p>
                <p>
                    Throughout her journey, she has combined her knowledge in health and psychology with her love for beauty
                    and the care of natural hair. In <strong class="text-gray-900">2021</strong>, she decided to take a bold
                    step and create Afro Jee after personally experiencing the difficulty of finding suitable products for
                    afro-textured hair in Barcelona.
                </p>
                <div class="pt-8">
                    <blockquote class="text-2xl md:text-3xl font-light text-gray-900 italic">
                        "Caring for afro hair is also an act of self-love,<br class="hidden md:block"> identity, and
                        cultural pride."
                    </blockquote>
                    <p class="text-[#ef380d] mt-4 font-medium">— Jennifer Pokuaa Effah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Coverage Section -->
    <section id="our-coverage" class="bg-[#F8F7F4] py-20 px-6 md:px-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-sm tracking-[0.2em] text-gray-500 uppercase mb-4">Global Reach</p>
                <h2 class="text-4xl md:text-5xl font-light mb-6 text-gray-900">
                    Our Coverage
                </h2>
                <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                    Afro Jee currently operates across several countries in Africa, Europe, and the Americas — including
                    Ghana, Nigeria, Spain, Portugal, France, Germany, the UK, the USA, Canada, Brazil, and more.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Map -->
                <div class="flex justify-center w-full">
                    <div id="chartdiv" style="width: 100%; height: 500px; max-width: 600px;">
                        <script>
                            var visitedplaces_config = {
                                "map": "world",
                                "projection": "geoNaturalEarth1",
                                "theme": "dark-green",
                                "water": 0,
                                "graticule": 0,
                                "names": 1,
                                "duration": 1500,
                                "slider": 0,
                                "autoplay": 1,
                                "data": [
                                    {
                                        "colors": {},
                                        "places": [
                                            "ES", "PT", "FR", "GB", "DE", "BE", "NL", "AT",
                                            "IT", "CH", "PL", "NO", "IE", "US", "CA", "BR", "NG", "GH"
                                        ],
                                        "name": "Afro Jee Coverage",
                                        "color": "fa6016"
                                    }
                                ],
                                "home": "ES"
                            };
                        </script>

                        <script src="https://www.visitedplaces.com/js/common.js"></script>
                        <script src="https://www.visitedplaces.com/js/viewer.js"></script>

                        <script>
                            window.addEventListener('load', function () {
                                const countries = visitedplaces_config.data[0].places;
                                let index = 0;
                                const zoomDuration = 3000;
                                const worldPause = 2500;
                                const betweenZooms = 1500;

                                function highlightCountry(code) {
                                    const el = document.querySelector(`[data-country="${code}"]`);
                                    if (el) {
                                        el.classList.add('glow-country');
                                        setTimeout(() => el.classList.remove('glow-country'), zoomDuration);
                                    }
                                }

                                function nextCountry() {
                                    const country = countries[index];

                                    if (window.visitedplaces_viewer && typeof visitedplaces_viewer.zoomTo === 'function') {
                                        visitedplaces_viewer.zoomTo(country);
                                        highlightCountry(country);
                                    }

                                    index++;

                                    if (index >= countries.length) {
                                        setTimeout(() => {
                                            if (visitedplaces_viewer && typeof visitedplaces_viewer.resetZoom === 'function') {
                                                visitedplaces_viewer.resetZoom();
                                            } else {
                                                visitedplaces_viewer.zoomTo('world');
                                            }
                                            index = 0;
                                            setTimeout(nextCountry, worldPause);
                                        }, zoomDuration);
                                    } else {
                                        setTimeout(nextCountry, zoomDuration + betweenZooms);
                                    }
                                }

                                setTimeout(nextCountry, 2000);
                            });
                        </script>

                        <style>
                            .glow-country {
                                stroke: #fa6016 !important;
                                stroke-width: 2px;
                                filter: drop-shadow(0 0 8px #fa6016);
                                animation: glowPulse 1.5s ease-in-out infinite alternate;
                            }

                            @keyframes glowPulse {
                                from { filter: drop-shadow(0 0 4px #fa6016); }
                                to { filter: drop-shadow(0 0 12px #fa6016); }
                            }
                        </style>
                    </div>
                </div>

                <!-- Coverage Stats -->
                <div class="space-y-8">
                    <div class="bg-white rounded-lg p-8 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-[#ef380d]/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#ef380d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">Multiple Continents</h3>
                                <p class="text-gray-600">Active operations across Africa, Europe, and the Americas with
                                    growing presence worldwide.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-8 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-[#ef380d]/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">Rapid Expansion</h3>
                                <p class="text-gray-600">Continuously expanding to more regions to bring natural self-care
                                    essentials to communities globally.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-8 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-[#ef380d]/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 104 0v-1a2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">Trusted Quality</h3>
                                <p class="text-gray-600">Handmade products with consistent quality standards across all
                                    markets we serve.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-white py-20 px-6 md:px-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-light mb-8 text-gray-900">
                Join us on our journey
            </h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
                Join us on our journey to celebrate natural beauty, one product at a time. At Afro Jee, it's not just about
                looking good—it's about feeling good too.
            </p>
            <a href="{{ route('web.products') }}"
                class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-10 py-4 rounded-full font-medium transition-all duration-300 hover:scale-105 shadow-sm">
                Explore Our Products
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    <style>
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Custom decorative elements */
        .glow-country {
            stroke: #ef380d !important;
            stroke-width: 2px;
            filter: drop-shadow(0 0 8px #ef380d);
            animation: glowPulse 1.5s ease-in-out infinite alternate;
        }

        @keyframes glowPulse {
            from {
                filter: drop-shadow(0 0 4px #ef380d);
            }

            to {
                filter: drop-shadow(0 0 12px #ef380d);
            }
        }

        /* Typography refinements */
        h1,
        h2,
        h3 {
            letter-spacing: -0.02em;
        }

        /* Image hover effects */
        section img {
            transition: transform 0.3s ease;
        }

        section:hover img {
            transform: scale(1.02);
        }
    </style>

    <script>
        // Map animation script
        window.addEventListener('load', function () {
            if (typeof visitedplaces_config !== 'undefined') {
                const countries = visitedplaces_config.data[0].places;
                let index = 0;
                const zoomDuration = 3000;
                const worldPause = 2500;
                const betweenZooms = 1500;

                function highlightCountry(code) {
                    const el = document.querySelector(`[data-country="${code}"]`);
                    if (el) {
                        el.classList.add('glow-country');
                        setTimeout(() => el.classList.remove('glow-country'), zoomDuration);
                    }
                }

                function nextCountry() {
                    const country = countries[index];

                    if (window.visitedplaces_viewer && typeof visitedplaces_viewer.zoomTo === 'function') {
                        visitedplaces_viewer.zoomTo(country);
                        highlightCountry(country);
                    }

                    index++;

                    if (index >= countries.length) {
                        setTimeout(() => {
                            if (visitedplaces_viewer && typeof visitedplaces_viewer.resetZoom === 'function') {
                                visitedplaces_viewer.resetZoom();
                            }
                            index = 0;
                            setTimeout(nextCountry, worldPause);
                        }, zoomDuration);
                    } else {
                        setTimeout(nextCountry, zoomDuration + betweenZooms);
                    }
                }

                setTimeout(nextCountry, 2000);
            }
        });
    </script>

@endsection