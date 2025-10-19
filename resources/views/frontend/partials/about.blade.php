@extends('frontend.layouts.app')

@section('title', 'About Us | Afro Jee')

@section('head')
    {{-- Custom Meta Tags for Sharing --}}
    <meta name="description"
        content="Discover Afro Jee's story - founded in Barcelona by Jennifer Pokuaa Effah to celebrate natural beauty with handmade, authentic hair care products.">
    <meta name="keywords" content="Afro Jee, about us, natural hair care, handmade products, Barcelona, Jennifer Pokuaa Effah">

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@AfroJee" />
    <meta name="twitter:image" content="{{ asset('images/about-share.jpg') }}" />

    <meta property="og:title" content="About Afro Jee - Your Beauty, Your Confidence" />
    <meta property="og:site_name" content="Afro Jee" />
    <meta property="og:url" content="{{ url('/about-us') }}" />
    <meta property="og:description" content="Born from passion in Barcelona, Afro Jee celebrates natural beauty with handmade, authentic hair care products." />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{ asset('images/about-share.jpg') }}" />
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-[#F5F3E7] to-orange-50 px-6 py-16 md:px-20">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center mb-8">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-light w-1/4 text-[#ef380d] mb-2">
                    About <br><span class="font-bold text-[#ef380d]">Us</span>
                </h2>
                <div class="bg-[#ef380d]/60 h-1 w-3/4 min-w-lg mt-4 mb-8"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-[#2E2E2E] text-lg leading-relaxed mb-6">
                        <strong class="text-[#ef380d]">Afro Jee</strong> was born from the desire to <strong>celebrate and care for natural beauty in all its forms</strong>. The name <em>Jee</em> comes from <em>Jenny</em>, symbolizing <strong>dedication, creativity, and authenticity</strong> — a brand built from love, experience, and identity.
                    </p>
                    
                    <p class="text-[#2E2E2E] text-lg leading-relaxed mb-6">
                        Founded in <strong>2021</strong> in <strong>Barcelona, Spain</strong>, by <strong>Jennifer Pokuaa Effah</strong>, a proud Ghanaian entrepreneur, Afro Jee began as a personal dream inspired by her lifelong passion for haircare and natural products.
                    </p>

                    <p class="text-[#2E2E2E] text-lg leading-relaxed">
                        At Afro Jee, we don't just create hair products — <strong>we create confidence, care, and connection</strong>. Our journey started with a simple idea: to offer <strong>high-quality, handmade products</strong> that help people care for their natural hair with pride and joy.
                    </p>
                </div>
                
                <div class="relative">
                    <img src="{{ asset('images/founder-jennifer.jpEg') }}" alt="Jennifer Pokuaa Effah - Founder of Afro Jee" 
                         class="rounded-2xl shadow-2xl border-4 border-[#ef380d]/20 w-full h-auto">
                    <div class="absolute -bottom-4 -right-4 bg-[#ef380d] text-white px-4 py-2 rounded-lg">
                        <p class="text-sm font-semibold">Jennifer Pokuaa Effah</p>
                        <p class="text-xs">Founder & CEO</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Story Section -->
    <section class="bg-[#FAEFF8] px-6 py-16 md:px-20 relative overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-3xl md:text-4xl font-semibold text-[#ef380d] mb-8 text-center">About The Founder</h3>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-[#ef380d]/10 rounded-full"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[#ef380d]/5 rounded-full"></div>
                    
                    <div class="relative z-10 bg-white p-8 rounded-2xl shadow-lg border border-[#ef380d]/10">
                        <p class="text-[#2E2E2E] text-lg leading-relaxed mb-6">
                            <strong>Jennifer Pokuaa Effah</strong> is a young <strong>Psychology graduate</strong> with a <strong>Master's degree in Occupational Risk Prevention</strong>, passionate about personal growth, continuous learning, and the overall well-being of people.
                        </p>
                        
                        <p class="text-[#2E2E2E] text-lg leading-relaxed">
                            Throughout her journey, she has combined her knowledge in health and psychology with her love for beauty and the care of natural hair. In <strong>2021</strong>, she decided to take a bold step and create Afro Jee after personally experiencing the difficulty of finding suitable products for <strong>afro-textured hair</strong> in Barcelona.
                        </p>
                    </div>
                </div>
                
                <div>
                    <img src="{{ asset('images/afro-jee-products.jpeg') }}" alt="Afro Jee Natural Hair Products" 
                         class="rounded-2xl shadow-lg w-full h-auto border-4 border-[#ef380d]/10">
                </div>
            </div>
            
            <div class="mt-12 bg-white rounded-2xl p-8 shadow-lg border border-[#ef380d]/10">
                <p class="text-[#2E2E2E] text-lg leading-relaxed text-center">
                    <strong>"Caring for afro hair is also an act of self-love, identity, and cultural pride."</strong>
                </p>
                <p class="text-[#ef380d] text-center mt-4 font-semibold">— Jennifer Pokuaa Effah</p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section id="our-mission" class="bg-white px-6 py-16 md:px-20">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-8 rounded-2xl border border-[#ef380d]/10">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#ef380d] rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-semibold text-[#ef380d]">Our Mission</h3>
                    </div>
                    
                    <p class="text-[#2E2E2E] text-lg leading-relaxed mb-4">
                        Our mission at <strong>Afro Jee</strong> is to <strong>empower people to embrace and love their natural hair</strong> by providing nourishing, authentic, and effective products. We believe that every curl, coil, and texture deserves care, respect, and celebration.
                    </p>
                    
                    <p class="text-[#2E2E2E] text-lg leading-relaxed">
                        We are committed to offering <strong>handmade, high-quality products</strong> that promote <strong>hair health, confidence, and self-love</strong>. But our purpose goes far beyond selling — we aim to <strong>educate, guide, and inspire</strong> through every product we create and every person we reach.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-8 rounded-2xl border border-[#ef380d]/10">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#ef380d] rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-semibold text-[#ef380d]">Our Vision</h3>
                    </div>
                    
                    <p class="text-[#2E2E2E] text-lg leading-relaxed mb-4">
                        <strong>Our vision</strong> at <strong>Afro Jee</strong> is to become a <strong>trusted and recognized global brand</strong> that celebrates <strong>natural beauty, culture, and identity</strong>. We aspire to expand our community internationally while maintaining the same <strong>handmade quality, care, and authenticity</strong> that define us.
                    </p>
                    
                    <p class="text-[#2E2E2E] text-lg leading-relaxed">
                        But our vision goes beyond haircare. Through Afro Jee, we want to <strong>inspire, educate, and empower</strong> helping people feel proud of who they are, where they come from, and how they express themselves.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Coverage Section -->
    <section id="our-coverage" class="bg-[#fffaf6] px-6 py-16 md:px-20">
        <div class="max-w-6xl mx-auto">
            <div class="mb-12">
                <div class="flex items-center mb-2">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-light w-1/4 text-[#ef380d] mb-2">
                        Our <br><span class="font-bold text-[#ef380d]">Coverage</span>
                    </h2>
                    <div class="bg-[#ef380d]/60 h-1 w-3/4 min-w-lg mt-4 mb-8"></div>
                </div>
            </div>

            <p class="text-lg text-[#2E2E2E] leading-relaxed mb-10">
                Afro Jee currently operates across several countries in
                <span class="font-bold text-[#ef380d]">Africa</span>,
                <span class="font-bold text-[#ef380d]">Europe</span>,
                and <span class="font-bold text-[#ef380d]">the Americas</span> — including
                Ghana, Nigeria, Spain, Portugal, France, Germany, the UK, the USA, Canada, Brazil, and more.
                <br><br>
                We're continually expanding our reach to bring natural self-care essentials to more communities around the world.
            </p>

            <div class="grid md:grid-cols-2 gap-10 items-center">
                <!-- Interactive Map -->
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

                <!-- Coverage Highlights -->
                <div class="flex flex-col gap-6">
                    <div class="flex items-center md:justify-start bg-[#ef380d]/5 rounded-lg p-6 shadow-sm">
                        <svg class="w-8 h-8 mr-3 text-[#ef380d]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <p class="text-xl font-semibold text-[#2E2E2E]">
                            Active operations across multiple continents
                        </p>
                    </div>

                    <div class="flex items-center md:justify-start bg-[#ef380d]/5 rounded-lg p-6 shadow-sm">
                        <svg class="w-8 h-8 mr-3 text-[#ef380d]" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1c0 1.105.9 2 2 2h7a2 2 0 002-2v-1c0-1.105.9-2 2-2h1.945M8 12h2m-2 4h2m4-4h2m-2 4h2m-3.8-9a3.5 3.5 0 10.3 7h12c1.93 0 3.5-1.57 3.5-3.5S18.93 8 17 8H8.5z"/>
                        </svg>
                        <p class="text-xl font-semibold text-[#2E2E2E]">
                            Expanding to more regions soon
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-6xl mx-auto py-20 px-6 md:px-20 bg-gradient-to-r from-[#ef380d] to-[#8C2A4A] text-white rounded-2xl shadow-lg my-12">
        <div class="mb-10">
            <div class="flex items-center mb-2">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold w-1/4">Join <br><span class="font-light">Us</span>
                </h2>
                <div class="bg-white/50 h-1 w-3/4 min-w-lg mt-4 mb-8"></div>
            </div>
            <p class="text-lg leading-relaxed mb-8">
                Join us on our journey to celebrate natural beauty, one product at a time. At Afro Jee,
                it's not just about looking good—it's about feeling good too.
            </p>
            <a href="{{ route('web.products') }}"
                class="inline-block bg-white text-[#ef380d] hover:bg-[#fff5f0] px-8 py-4 rounded-full font-medium flex items-center gap-2 transition duration-300 ease-in-out shadow-md hover:scale-105">
                Explore Our Products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </section>

@endsection