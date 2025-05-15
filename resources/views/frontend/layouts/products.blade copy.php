<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Card Hover Effect</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            max-width: 1200px;
            width: 100%;
        }

        .product-card {
            position: relative;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .product-card.active {
            flex: 3;
            max-width: 300px;
            height: 400px;
            z-index: 10;
            transform: scale(1.05);
        }

        .product-card.inactive {
            flex: 1;
            max-width: 120px;
            height: 300px;
        }

        .product-image {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .quick-view-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: #800020;
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 0.75rem;
            cursor: pointer;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .product-card.active .quick-view-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .product-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(4px);
            padding: 1rem;
            transition: opacity 0.3s ease;
        }

        .product-title h3 {
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .product-card.inactive .product-title {
            opacity: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="product-card active" data-product="body-butter">
            <div class="product-image">
                <img src="/api/placeholder/300/400" alt="Body Butter">
                <button class="quick-view-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                <div class="product-title">
                    <h3>Body Butter</h3>
                </div>
            </div>
        </div>

        <div class="product-card inactive" data-product="serum">
            <div class="product-image">
                <img src="/api/placeholder/300/400" alt="Serum">
                <button class="quick-view-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                <div class="product-title">
                    <h3>Serum</h3>
                </div>
            </div>
        </div>

        <div class="product-card inactive" data-product="lip-balm">
            <div class="product-image">
                <img src="/api/placeholder/300/400" alt="Lip Balm">
                <button class="quick-view-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                <div class="product-title">
                    <h3>Lip Balm</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get all product cards
        const productCards = document.querySelectorAll('.product-card');

        // Add event listeners to each card
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                // Remove active class from all cards and add inactive
                productCards.forEach(c => {
                    c.classList.remove('active');
                    c.classList.add('inactive');
                });

                // Add active class to hovered card and remove inactive
                this.classList.add('active');
                this.classList.remove('inactive');
            });
        });
    </script>
</body>

</html>



<div class="relative flex gap-4 p-4">
    <!-- Product Card 1 (Default Active) -->
    <div
        class="product-card  h-90 w-150 rounded-xl bg-white shadow-lg transition-all duration-500 ease-in-out transform  hover:z-20">
        <div class="relative h-full w-full overflow-hidden rounded-xl">
            <img src="{{ asset('images/p3.png') }}" alt="Body Butter" class="h-full w-full object-cover">
            <!-- Quick View Button -->
            <button class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
            <!-- Title Overlay -->
            <div class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm p-4">
                <h3 class="text-white text-xl font-bold">Body Butter</h3>
            </div>
        </div>
    </div>
    <div class="relative hidden product-card2 w-fit rounded-lg bg-red overflow-hidden bg-white group">
        <!-- Product Image -->
        <div class="relative overflow-hidden w-60 h-90 rounded-lg">
            <img src="{{ asset('images/p2.png') }}" alt="Lip balm product" class="w-full h-full object-cover" />
        </div>
    </div>

    <!-- Product Card 2 -->
    <div
        class="product-card hidden h-80 rounded-xl bg-white shadow-lg transition-all duration-500 ease-in-out transform  hover:z-20">
        <div class="relative h-full w-full overflow-hidden rounded-xl">
            <img src="{{ asset('images/p2.png') }}" alt="Serum" class="h-full w-full object-cover">
            <!-- Quick View Button -->
            <button class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </div>
    <div class="relative product-card2 w-fit rounded-lg bg-red overflow-hidden bg-white group">
        <!-- Product Image -->
        <div class="relative overflow-hidden w-60 h-90 rounded-lg">
            <img src="{{ asset('images/p2.png') }}" alt="Lip balm product" class="w-full h-full object-cover" />
        </div>
    </div>

    <!-- Product Card 3 -->
    <div
        class="product-card hidden h-80 rounded-xl bg-white shadow-lg transition-all duration-500 ease-in-out transform  hover:z-20">
        <div class="relative h-full w-full overflow-hidden rounded-xl">
            <img src="{{ asset('images/p2.png') }}" alt="Lip Balm" class="h-full w-full object-cover">
            <!-- Quick View Button -->
            <button class="absolute top-4 right-4 bg-burgundy text-white rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </div>
    <div class="relative product-card2 w-fit rounded-lg bg-red overflow-hidden bg-white group">
        <!-- Product Image -->
        <div class="relative overflow-hidden w-60 h-90 rounded-lg">
            <img src="{{ asset('images/p2.png') }}" alt="Lip balm product" class="w-full h-full object-cover" />
        </div>
    </div>
</div>