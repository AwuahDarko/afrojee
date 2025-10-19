@extends('frontend.layouts.app')

@section('title', 'FAQs | Afro Jee')

@section('content')
    <style>
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .faq-content.active {
            max-height: 1000px;
            transition: max-height 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .plus-icon,
        .minus-icon {
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .faq-button[aria-expanded="true"] .plus-icon {
            opacity: 0;
            transform: rotate(90deg);
        }

        .faq-button[aria-expanded="false"] .minus-icon {
            opacity: 0;
            transform: rotate(-90deg);
        }

        .faq-button[aria-expanded="true"] span:not(.plus-icon):not(.minus-icon) {
            color: #ef380d;
            transition: color 0.3s ease;
        }

        .faq-button[aria-expanded="false"] span:not(.plus-icon):not(.minus-icon) {
            color: #374151;
            transition: color 0.3s ease;
        }

        .plus-icon,
        .minus-icon {
            transform-origin: center;
        }

        .faq-button[aria-expanded="true"] .minus-icon {
            opacity: 1;
            transform: rotate(0deg);
        }

        .faq-button[aria-expanded="false"] .plus-icon {
            opacity: 1;
            transform: rotate(0deg);
        }

        .submit-button-bg {
            background: linear-gradient(135deg, #ef380d, #d6320c);
        }

        .submit-button-bg:hover {
            background: linear-gradient(135deg, #d6320c, #bf2c0a);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 56, 13, 0.3);
        }

        .faq-section {
            scroll-margin-top: 100px;
        }
    </style>

    <!-- CRITICAL: Add the JavaScript file -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <section class="bg-gradient-to-br from-[#F5F3E7] to-orange-50/30 py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-gray-800 mb-4">
                    Got <span class="font-bold text-[#ef380d]">Questions?</span>
                </h2>
                <div class="w-24 h-1 bg-[#ef380d] mx-auto mb-6 rounded-full"></div>
                <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    We've compiled answers to the most common questions about our products, shipping, and more to help you
                    get the most out of your Afro Jee experience.
                </p>
            </div>

            <!-- FAQ Navigation -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="#shipping-faq"
                    class="bg-white border-2 border-[#ef380d] text-[#ef380d] px-6 py-3 rounded-2xl font-semibold hover:bg-[#ef380d] hover:text-white transition-all duration-300">
                    Shipping & Delivery
                </a>
                <a href="#payment-faq"
                    class="bg-white border-2 border-[#ef380d] text-[#ef380d] px-6 py-3 rounded-2xl font-semibold hover:bg-[#ef380d] hover:text-white transition-all duration-300">
                    Payment
                </a>
                <a href="#products-faq"
                    class="bg-white border-2 border-[#ef380d] text-[#ef380d] px-6 py-3 rounded-2xl font-semibold hover:bg-[#ef380d] hover:text-white transition-all duration-300">
                    Products
                </a>
            </div>

            <div class="space-y-4">
                <!-- Shipping & Delivery FAQs -->
                <div id="shipping-faq" class="faq-section">
                    <h3 class="text-2xl md:text-3xl font-bold text-[#ef380d] mb-6 border-b-2 border-[#ef380d]/20 pb-2">
                        Shipping & Delivery</h3>

                    <!-- FAQ Item 1 - Open by default -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="true">
                            <span class="font-bold text-lg">Do you ship internationally?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content active px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Certainly! We ship internationally. The estimated delivery time will be displayed at
                                checkout and depends on your delivery destination and selected shipping method. If you've
                                already placed an order, check your order confirmation email for shipping details. For
                                further assistance, contact us at <a href="mailto:info@afrojee.store"
                                    class="text-[#ef380d] hover:underline">info@afrojee.store</a>.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">When will my order be processed?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                All orders are shipped within 2 working days (excluding weekends and bank holidays). Once
                                your order has been shipped, you'll receive a confirmation email with tracking information.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">How can I track my order?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Once your order ships, you'll receive a confirmation email with your tracking number. You
                                can use this number to track your package in real-time through our website or the carrier's
                                tracking system.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">Can I change my delivery address?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                If your order has already entered the shipping stage, we may not be able to cancel it.
                                However, please contact our customer support at <a href="mailto:info@afrojee.store"
                                    class="text-[#ef380d] hover:underline">info@afrojee.store</a> for assistance. We'll do
                                our best to help!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment FAQs -->
                <div id="payment-faq" class="faq-section mt-12">
                    <h3 class="text-2xl md:text-3xl font-bold text-[#ef380d] mb-6 border-b-2 border-[#ef380d]/20 pb-2">
                        Payment</h3>

                    <!-- FAQ Item 5 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">What currency is your store in?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                At Afro Jee, all transactions are processed in Euros (€) to ensure a simple and transparent
                                shopping experience for our customers across Europe. Depending on your location and payment
                                provider, you may also view prices or complete your purchase in your local currency during
                                checkout.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">What payment options do you accept?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                We offer several secure payment options: all major credit and debit cards (Visa, MasterCard,
                                American Express, Maestro), PayPal, and Apple Pay. All payments are processed through
                                trusted, encrypted gateways to ensure your data remains secure.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Products FAQs -->
                <div id="products-faq" class="faq-section mt-12">
                    <h3 class="text-2xl md:text-3xl font-bold text-[#ef380d] mb-6 border-b-2 border-[#ef380d]/20 pb-2">
                        Products</h3>

                    <!-- FAQ Item 7 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">Can I get my product personalized?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Our current sets are predesigned with carefully selected combinations to meet specific hair
                                needs. While we don't yet offer fully personalized sets, we understand that every hair
                                journey is unique. If you'd like to create a custom combination or prepare a special gift
                                set using individual products, contact us at <a href="mailto:info@afrojee.store"
                                    class="text-[#ef380d] hover:underline">info@afrojee.store</a>. We're working on
                                personalized options, so stay tuned for custom Afro Jee gift boxes!
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">Are your products suitable for all hair types?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Yes! Afro Jee products are specially formulated for afro-textured hair but work wonderfully
                                on all hair types. Our natural ingredients are gentle yet effective, making them suitable
                                for various curl patterns and textures.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 9 -->
                    <div
                        class="border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:shadow-lg">
                        <button
                            class="faq-button w-full flex justify-between items-center px-6 py-5 text-left focus:outline-none"
                            aria-expanded="false">
                            <span class="font-bold text-lg">How should I store my Afro Jee products?</span>
                            <div class="relative ml-2">
                                <span
                                    class="plus-icon bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                <span
                                    class="minus-icon absolute top-0 left-0 bg-[#ef380d]/10 rounded-full w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#ef380d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-700 leading-relaxed">
                                Store your Afro Jee products in a cool, dry place away from direct sunlight. Some products
                                with natural ingredients may benefit from refrigeration during hot weather. Always check
                                product labels for specific storage instructions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <!-- <section class="bg-white py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                        Still Have <span class="text-[#ef380d]">Questions?</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Can't find what you're looking for? We're here to help! Send us your questions and we'll get back to
                        you within 24 hours.
                    </p>
                    <div class="flex items-center justify-center md:justify-start text-gray-600 mb-6">
                        <svg class="w-6 h-6 mr-3 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>info@afrojee.store</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-8 rounded-2xl border border-[#ef380d]/10">
                    <form class="space-y-6">
                        <div>
                            <input type="text" id="name" placeholder="Your Name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white transition duration-200">
                        </div>
                        <div>
                            <input type="email" id="email" placeholder="Your Email Address"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white transition duration-200">
                        </div>
                        <div>
                            <textarea id="message" rows="5" placeholder="Your Message"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white resize-none transition duration-200"></textarea>
                        </div>
                        <button type="submit"
                            class="submit-button-bg hover:submit-button-hover text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 ease-in-out w-full">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section> -->
<section class="bg-white py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Contact Form Section -->
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div class="text-center md:text-left">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Still Have <span class="text-[#ef380d]">Questions?</span>
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Can't find what you're looking for? We're here to help! Send us your questions and we'll get back to
                    you within 24 hours.
                </p>
                <div class="flex items-center justify-center md:justify-start text-gray-600 mb-6">
                    <svg class="w-6 h-6 mr-3 text-[#ef380d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>info@afrojee.store</span>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#ef380d]/5 to-orange-50/50 p-8 rounded-2xl border border-[#ef380d]/10">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" id="contactForm">
                    @csrf
                    
                    @if(session('contact_success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    <div>
                        <input type="text" name="name" id="name" placeholder="Your Name" required
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white transition duration-200 @error('name') border-red-500 @enderror">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <input type="email" name="email" id="email" placeholder="Your Email Address" required
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white transition duration-200 @error('email') border-red-500 @enderror">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <textarea name="message" id="message" rows="5" placeholder="Your Message" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#ef380d] focus:border-[#ef380d] bg-white resize-none transition duration-200 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-[#ef380d] to-[#d6320c] hover:from-[#d6320c] hover:to-[#bf2c0a] text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 ease-in-out w-full hover:shadow-lg">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="bg-gradient-to-r from-[#f06243ff] to-[#d6320c] rounded-3xl p-8 md:p-12 text-white">
            <div class="max-w-4xl mx-auto text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    </svg>
                </div>
                
                <h3 class="text-3xl md:text-4xl font-bold mb-4">
                    Subscribe to Our Newsletter
                </h3>
                <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
                    Get exclusive deals, product updates, and special offers delivered straight to your inbox. Join our community today!
                </p>

                @if(session('newsletter_success'))
                    <div class="bg-white/20 border border-white/30 text-white px-4 py-3 rounded-xl mb-6 backdrop-blur-sm">
                        {{ session('newsletter_success') }}
                    </div>
                @endif

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="max-w-xl mx-auto" id="newsletterForm">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="newsletter_email" placeholder="Enter your email address" required
                            value="{{ old('newsletter_email') }}"
                            class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/30 @error('newsletter_email') border-2 border-red-300 @enderror">
                        <button type="submit"
                            class="bg-white text-[#ef380d] font-semibold px-8 py-4 rounded-xl hover:bg-gray-50 transition-all duration-300 ease-in-out hover:shadow-xl whitespace-nowrap">
                            Subscribe Now
                        </button>
                    </div>
                    @error('newsletter_email')
                        <span class="text-white/90 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                    <p class="text-white/70 text-sm mt-4">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection