

    <style>
        :root {
            --burgundy: #800020;
            --taupe: #8B7355;
            --gold: #F3BF45;
        }

        .text-burgundy { color: var(--burgundy); }
        .bg-burgundy { background-color: var(--burgundy); }
        .border-burgundy { border-color: var(--burgundy); }
        .text-taupe { color: var(--taupe); }
        .bg-taupe { background-color: var(--taupe); }

        .product-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .product-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            transition: all 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.1);
        }

        .cart-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(10px);
            opacity: 0;
        }

        .product-card:hover .cart-button {
            transform: translateY(0);
            opacity: 1;
        }

        .quantity-badge {
            background: linear-gradient(135deg, var(--gold), #e6ac39);
            animation: pulse 2s infinite;
        }

        .new-badge {
            background: linear-gradient(135deg, #10b981, #059669);
            animation: shimmer 2s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes shimmer {
            0% { opacity: 0.8; }
            100% { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating-accent {
            animation: float 6s ease-in-out infinite;
        }

        .hover-accent {
            opacity: 0;
            transform: scale(0.8) rotate(-5deg);
            transition: all 0.4s ease;
        }

        .product-card:hover .hover-accent {
            opacity: 0.7;
            transform: scale(1) rotate(0deg);
        }

        .price-tag {
            background: linear-gradient(135deg, var(--burgundy), #a0002a);
            clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%);
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }
    </style>
<body class="bg-gray-50">
    <!-- Header Section -->
    <section class="py-16 px-4 md:px-8">
        <div class="container mx-auto max-w-7xl">
            <!-- Section Heading -->
            <div class="mb-12">
                <div class="flex items-center mb-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe">
                        Our <br><span class="font-bold">Products</span>
                    </h1>
                    <div class="bg-taupe h-1 w-full min-w-32 mt-4 ml-8"></div>
                </div>
                <p class="text-taupe text-lg md:text-xl max-w-4xl">
                    Discover our exclusive range of premium skincare essentials, crafted to keep your routine simple and effective
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid-container" id="productsGrid">
                <!-- Product cards will be generated here -->
            </div>
        </div>
    </section>

    <script>
        // Sample product data - replace with your actual data
        const products = [
            {
                id: 1,
                name: "Luxe Body Butter",
                slug: "luxe-body-butter",
                description: "Rich, nourishing body butter with natural ingredients",
                price: 45.99,
                quantity: 23,
                image: "https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=400&fit=crop",
                created_at: "2024-12-15",
                featured: true
            },
            {
                id: 2,
                name: "Revitalizing Face Serum",
                slug: "revitalizing-face-serum",
                description: "Anti-aging serum with vitamin C and hyaluronic acid",
                price: 89.99,
                quantity: 7,
                image: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop",
                created_at: "2024-06-20",
                featured: false
            },
            {
                id: 3,
                name: "Organic Lip Balm",
                slug: "organic-lip-balm",
                description: "Natural lip balm with shea butter and vitamin E",
                price: 12.99,
                quantity: 156,
                image: "https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop",
                created_at: "2024-12-20",
                featured: true
            },
            {
                id: 4,
                name: "Gentle Cleansing Oil",
                slug: "gentle-cleansing-oil",
                description: "Deep cleansing oil that removes makeup and impurities",
                price: 34.99,
                quantity: 89,
                image: "https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=400&h=400&fit=crop",
                created_at: "2024-11-10",
                featured: false
            },
            {
                id: 5,
                name: "Hydrating Night Cream",
                slug: "hydrating-night-cream",
                description: "Intensive night cream for deep hydration and repair",
                price: 67.99,
                quantity: 2,
                image: "https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&h=400&fit=crop",
                created_at: "2024-12-25",
                featured: true
            },
            {
                id: 6,
                name: "Exfoliating Body Scrub",
                slug: "exfoliating-body-scrub",
                description: "Natural sugar scrub for smooth, radiant skin",
                price: 29.99,
                quantity: 45,
                image: "https://images.unsplash.com/photo-1576426863848-c21f53c60b19?w=400&h=400&fit=crop",
                created_at: "2024-12-28",
                featured: false
            }
        ];

        function isNewProduct(createdAt) {
            const createdDate = new Date(createdAt);
            const now = new Date();
            const diffTime = Math.abs(now - createdDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= 50;
        }

        function getQuantityStatus(quantity) {
            if (quantity <= 5) return { status: 'critical', color: 'bg-red-500', text: 'Almost Out!' };
            if (quantity <= 20) return { status: 'low', color: 'bg-yellow-500', text: 'Low Stock' };
            return { status: 'good', color: 'bg-green-500', text: 'In Stock' };
        }

        function createProductCard(product) {
            const isNew = isNewProduct(product.created_at);
            const quantityStatus = getQuantityStatus(product.quantity);
            
            return `
                <div class="group relative product-card bg-secondary rounded-2xl shadow-lg overflow-hidden">
                    <!-- Decorative Accent -->
                    <div class="hover-accent absolute -top-4 -left-4 z-10">
                        <svg width="120" height="60" viewBox="0 0 231 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.6">
                                <path d="M9.89791 12.1723C32.8258 10.1112 99.2605 12.0607 181.576 36.3473" stroke="#F3BF45" stroke-width="8" stroke-linecap="round" />
                                <path d="M28.9994 34.4957C48.8452 31.1511 107.093 26.8951 181.32 36.6272" stroke="#F3BF45" stroke-width="8" stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>

                    <!-- Badges -->
                    <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
                        ${isNew ? '<span class="new-badge text-white text-xs font-bold px-3 py-1 rounded-full">NEW</span>' : ''}
                        <span class="quantity-badge text-white text-xs font-bold px-3 py-1 rounded-full">
                            ${product.quantity} left
                        </span>
                    </div>

                    <!-- Stock Status -->
                    <div class="absolute top-4 right-4 z-20">
                        <div class="flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1">
                            <div class="w-2 h-2 rounded-full ${quantityStatus.color}"></div>
                            <span class="text-xs font-medium text-gray-700">${quantityStatus.text}</span>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="relative h-64 md:h-72 overflow-hidden">
                        <img src="${product.image}" alt="${product.name}" 
                             class="product-image w-full h-full object-cover">
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-burgundy transition-colors">
                            ${product.name}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            ${product.description}
                        </p>
                        
                        <!-- Price and Actions -->
                        <div class="flex items-center justify-between">
                            <div class="price-tag text-white font-bold text-lg px-4 py-2 rounded-l-lg">
                                $${product.price}
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button class="cart-button bg-burgundy text-white p-3 rounded-full hover:bg-opacity-90 transition-all duration-300 hover:scale-110"
                                        onclick="addToCart(${product.id})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.8-9M7 13l-1.8-9m0 0L3 3m4 10v6a2 2 0 002 2h6a2 2 0 002-2v-6M9 19h6"></path>
                                    </svg>
                                </button>
                                
                                <button class="cart-button bg-taupe text-white p-3 rounded-full hover:bg-opacity-90 transition-all duration-300 hover:scale-110"
                                        onclick="viewProduct('${product.slug}')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderProducts() {
            const grid = document.getElementById('productsGrid');
            grid.innerHTML = products.map(product => createProductCard(product)).join('');
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (product && product.quantity > 0) {
                // Animate button
                event.target.closest('button').style.transform = 'scale(0.95)';
                setTimeout(() => {
                    event.target.closest('button').style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        event.target.closest('button').style.transform = 'scale(1)';
                    }, 150);
                }, 100);
                
                // Here you would typically send to your backend
                console.log(`Added ${product.name} to cart`);
                
                // Show success message (you can customize this)
                showNotification(`${product.name} added to cart!`, 'success');
            } else {
                showNotification('Product is out of stock!', 'error');
            }
        }

        function viewProduct(slug) {
            // Navigate to product detail page
            console.log(`Viewing product: ${slug}`);
            // window.location.href = `/products/details/${slug}`;
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transition-all duration-300 transform translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
        });
    </script>
</body>
</html>