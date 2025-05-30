<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    .gold-accent {
        position: absolute;
        top: 20px;
        left: -20px;
        width: 200px;
        height: 80px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 80'%3E%3Cpath d='M10,40 Q50,10 100,40 Q150,70 190,40' stroke='%23C8A655' stroke-width='12' fill='none' /%3E%3C/svg%3E") no-repeat;
        z-index: 1;
        opacity: 0.7;
    }
</style>
<script src="{{ asset('js/product.js') }}"></script>

<section class="py-16 px-4 md:px-8">
    <div class="container mx-auto mmax-container">
        <!-- Section Heading -->
        <div class="mb-12">
            <div class="flex items-center mmax-products mb-2">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe mb-2">
                    Our <br><span class="font-bold">Products</span>
                </h2>
                <div class="bg-taupe h-1 backdrop-blur-sm  w-full min-w-lg mt-4 mb-8"></div>
            </div>
            <p class="text-taupe text-lg md:text-xl max-w-4xl">
                Check out our exclusive range of essentials, made to keep your routine simple and effective
            </p>
        </div>

        <!-- Products Grid -->
        <!-- <div class="relative grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 p-4"> -->
        <div class="flex gap-4 p-0 max-w-8xl mx-auto" id="productCards">
            @foreach ($featured_products as $product)
            <div class="group relative product-card flex-1 max-w-[400px] h-[350px] bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-500 ease-in-out active"
            data-title="Body Butter" data-img-default="{{$product->image}}"
            data-img-active="{{$product->image}}">
            <a href="/products/details/{{ $product->slug }}">
                        <div class="relative h-full w-full">
                            <img src="/images/p3.jpg" alt="Body Butter"
                                class="product-image h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            <button
                                class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
                                <!-- arrow icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <button
                                class="absolute -top-15 z-100 -left-15 p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
                                <svg width="231" height="94" viewBox="0 0 231 94" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="0.5">
                                        <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473"
                                            stroke="#F3BF45" stroke-width="19.0517" stroke-linecap="round" />
                                        <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272"
                                            stroke="#F3BF45" stroke-width="19.0517" stroke-linecap="round" />
                                        <path d="M29.6353 34.4891C55.2714 36.0577 129.41 48.0769 220.874 83.6052"
                                            stroke="#F3BF45" stroke-width="19.0517" stroke-linecap="round" />
                                    </g>
                                </svg>

                            </button>
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm p-4 opacity-100 group-[.inactive]:opacity-0 transition-opacity duration-300">
                                <h3 class="text-white text-xl font-bold"> {{$product->name}} </h3>
                            </div>
                        </div>
                    </a>
                    </div>
            @endforeach




        </div>

        <!-- View All Products Button -->
        <div class="flex justify-end mt-12">
            <a href="{{ route('web.products') }}"
                class="inline-flex items-center justify-center px-8 py-3 rounded-full border-2 border-burgundy text-burgundy hover:bg-burgundy hover:text-white transition-colors">
                View All Products
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- <div
    class="group relative product-card flex-1 max-w-[400px] h-[350px] bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-500 ease-in-out inactive"
    data-title="Serum" data-img-default="/images/p2.png" data-img-active="/images/p2-active.png">
    <div class="relative h-full w-full">
        <img src="/images/p2.png" alt="Serum"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
        <button
            class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
        <button
            class="absolute -top-15 z-100 -left-15 p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg width="231" height="94" viewBox="0 0 231 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.5">
                    <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M29.6353 34.4891C55.2714 36.0577 129.41 48.0769 220.874 83.6052" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                </g>
            </svg>

        </button>
        <div
            class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm p-4 opacity-100 group-[.inactive]:opacity-0 transition-opacity duration-300">
            <h3 class="text-white text-xl font-bold">Serum</h3>
        </div>
    </div>
</div>


<div class="group relative product-card flex-1 max-w-[400px] h-[350px] bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-500 ease-in-out inactive"
    data-title="Lip Balm" data-img-default="/images/p2.png" data-img-active="/images/p2-active.png">
    <div class="relative h-full w-full">
        <img src="/images/p2.png" alt="Lip Balm"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
        <button
            class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
        <button
            class="absolute -top-15 z-100 -left-15 p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg width="231" height="94" viewBox="0 0 231 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.5">
                    <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M29.6353 34.4891C55.2714 36.0577 129.41 48.0769 220.874 83.6052" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                </g>
            </svg>

        </button>
        <div
            class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm p-4 opacity-100 group-[.inactive]:opacity-0 transition-opacity duration-300">
            <h3 class="text-white text-xl font-bold">Lip Balm</h3>
        </div>
    </div>
</div>


<div class="group relative product-card flex-1 max-w-[400px] h-[350px] bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-500 ease-in-out inactive"
    data-title="Lip Balm" data-img-default="/images/p2.png" data-img-active="/images/p2-active.png">
    <div class="relative h-full w-full">
        <img src="/images/p2.png" alt="Lip Balm"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
        <!-- <img src="/images/line.png" alt="Lip Balm"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" /> -->
        <button
            class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
        <button
            class="absolute -top-15 z-100 -left-15 p-3 opacity-0 group-[.active]:opacity-100 transform group-[.active]:translate-y-0 translate-y-[-10px] transition-all duration-300">
            <svg width="231" height="94" viewBox="0 0 231 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.5">
                    <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                    <path d="M29.6353 34.4891C55.2714 36.0577 129.41 48.0769 220.874 83.6052" stroke="#F3BF45"
                        stroke-width="19.0517" stroke-linecap="round" />
                </g>
            </svg>

        </button>
        <div
            class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm p-4 opacity-100 group-[.inactive]:opacity-0 transition-opacity duration-300">
            <h3 class="text-white text-xl font-bold">Lip Balm</h3>
        </div>
    </div>
</div> --}}