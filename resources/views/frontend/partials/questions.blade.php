@extends('frontend.layouts.app') @section('content')
    <section class="bg-[#f5f3e8]">
        <div class="container mx-auto px-1 py-30 ">
            <div>
                <h2 class="text-5xl font-medium text-gray-700">Got</h2>
                <h2 class="text-5xl font-semibold text-gray-700 mb-6">Questions?</h2>
                <div class="border-t border-gray-300 mb-8"></div>
                <p class="text-gray-700 mb-10">
                    Check out our FAQ section where we've answered some of the most common queries to help you get the most
                    out of our products
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 - Open by default -->
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
                        aria-expanded="true">
                        <span class="font-bold">Are your products suitable for all skin and hair types?</span>
                        <div class="relative ml-2">
                            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span
                                class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="faq-content active px-6 pb-4">
                        <p class="text-gray-700">
                            Yes, our products are designed to be gentle and effective for all skin and hair types, including
                            sensitive skin and delicate hair
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
                        aria-expanded="false">
                        <span class="font-bold">Can I buy your products in physical stores?</span>
                        <div class="relative ml-2">
                            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span
                                class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-700">
                            Yes, our products are available in select retail locations across the country. We partner with
                            beauty boutiques, spa retreats, and select department stores. You can use our store locator on
                            our website to find the nearest retailer carrying YaaSerwa products.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
                        aria-expanded="false">
                        <span class="font-bold">Do you offer any discounts or promotions?</span>
                        <div class="relative ml-2">
                            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span
                                class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-700">
                            Yes, we frequently offer seasonal promotions and special discounts. Subscribe to our newsletter
                            to stay updated on our latest offers. We also have a loyalty program where you earn points on
                            every purchase that can be redeemed for discounts on future orders.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
                        aria-expanded="false">
                        <span class="font-bold">How long will it take to receive my order?</span>
                        <div class="relative ml-2">
                            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span
                                class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-700">
                            Domestic orders typically arrive within 3-5 business days. International shipping can take 7-14
                            business days depending on your location. We offer expedited shipping options at checkout if you
                            need your products sooner.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div
                    class="border border-gray-200 rounded-lg overflow-hidden bg-white transition-all duration-300 hover:shadow-md">
                    <button
                        class="faq-button w-full flex justify-between items-center px-6 py-4 text-left focus:outline-none"
                        aria-expanded="false">
                        <span class="font-bold">How should I store my products?</span>
                        <div class="relative ml-2">
                            <span class="plus-icon bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span
                                class="minus-icon absolute top-0 left-0 bg-pink-100 rounded-full w-8 h-8 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <div class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-700">
                            For optimal quality and longevity, store your Afro Jee products in a cool, dry place away from
                            direct sunlight. Some of our products containing natural ingredients may be better stored in the
                            refrigerator, particularly during hot weather. Each product label provides specific storage
                            instructions.
                        </p>
                    </div>
                </div>
            </div>

            <!-- <div class="flex justify-end mt-10">
                <a href="#"
                    class="bg-rose-700 text-white px-6 py-3 rounded-full flex items-center hover:bg-rose-800 transition-colors duration-300">
                    View More
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                    </svg>
                </a>
            </div> -->
        </div>

    </section>
    <section class="max-w-7xl mx-auto py-30">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="flex-shrink-0 relative w-48 h-48 md:w-64 md:h-64">
                <!-- <svg class="w-full h-full question-mark-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.44 12.9 13 13.5 13 14h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.35 1.7-.93 2.35z" />
                </svg> -->
                <img src="/images/faq.png" alt="Body Butter"
                        class="product-image h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    
            </div>

            <div class="flex-grow text-center md:text-left">
                <h1 class="text-4xl font-semibold text-gray-800 mb-4">Still Got Questions?</h1>
                <p class="text-lg text-gray-700 leading-relaxed mb-8">
                    Kindly enter your details and specific concerns and we'll get
                    right back to you with a response!
                </p>

                <form class="max-w-2xl">
                    <div class="mb-4">
                        <input type="text" id="name" placeholder="Enter your Name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800 bg-white">
                    </div>
                    <div class="mb-4">
                        <input type="email" id="email" placeholder="Enter your Email address"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800 bg-white">
                    </div>
                    <div class="mb-6">
                        <textarea id="message" rows="5" placeholder="Enter your Message"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-800 bg-white resize-none"></textarea>
                    </div>
                    <button type="submit"
                        class="submit-button-bg hover:submit-button-hover text-white font-semibold px-8 py-3 rounded-full transition duration-300 ease-in-out">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection