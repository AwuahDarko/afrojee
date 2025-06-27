<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .star-rating {
            color: #fbbf24;
        }
        .star-empty {
            color: #d1d5db;
        }
        .review-card {
            transition: all 0.3s ease;
        }
        .review-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Read</h1>
                <h2 class="text-3xl font-bold text-gray-700 mb-4">Our Reviews</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Don't just take our word for it—see what our customers are saying about their experience!
                </p>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-8">
                <div class="relative flex-1 max-w-md">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Enter product to search" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <button class="absolute right-2 top-2 text-gray-400 hover:text-purple-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="flex gap-3">
                    <button 
                        id="allReviewsBtn"
                        class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full hover:bg-purple-200 transition-colors active"
                    >
                        All Reviews
                    </button>
                    <select 
                        id="productFilter"
                        class="px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                        <option value="">Select Product</option>
                    </select>
                    <button 
                        class="px-6 py-2 gradient-bg text-white rounded-full hover:opacity-90 transition-opacity"
                        onclick="openReviewModal()"
                    >
                        Leave A Review →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Reviews</h3>
        
        <!-- Loading State -->
        <div id="loadingState" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
        </div>

        <!-- Reviews Grid -->
        <div id="reviewsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" style="display: none;">
            <!-- Reviews will be inserted here -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="text-center py-12" style="display: none;">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-star text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Reviews Found</h3>
            <p class="text-gray-500">Be the first to leave a review!</p>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex justify-center items-center space-x-2 mt-8">
            <!-- Pagination will be inserted here -->
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Leave a Review</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="reviewForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                        <input type="text" name="product_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <div class="flex space-x-1">
                            <button type="button" class="star-btn text-2xl" data-rating="1">★</button>
                            <button type="button" class="star-btn text-2xl" data-rating="2">★</button>
                            <button type="button" class="star-btn text-2xl" data-rating="3">★</button>
                            <button type="button" class="star-btn text-2xl" data-rating="4">★</button>
                            <button type="button" class="star-btn text-2xl" data-rating="5">★</button>
                        </div>
                        <input type="hidden" name="rating" id="selectedRating" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review Title</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                        <textarea name="review" required rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeReviewModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 gradient-bg text-white rounded-md hover:opacity-90">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sample data - replace with actual API calls to your Laravel backend
        const sampleReviews = [
            {
                id: 1,
                name: "Maya",
                title: "Tree growth hair & scalp oil",
                review: "This body butter is a game-changer! My skin feels so soft and hydrated, and the scent is absolutely divine. A little goes a long way, so it's great value for money. Highly recommend!",
                rating: 4,
                product_name: "Hair & Scalp Oil",
                created_at: "2024-01-15",
                image: null
            },
            {
                id: 2,
                name: "Riley",
                title: "Always moisturized body cream",
                review: "This body butter is a game-changer! My skin feels so soft and hydrated, and the scent is absolutely divine. A little goes a long way, so it's great value for money. Highly recommend!",
                rating: 4,
                product_name: "Body Cream",
                created_at: "2024-01-20",
                image: null
            },
            {
                id: 3,
                name: "Briana",
                title: "Always moisturized body cream",
                review: "This body butter is a game-changer! My skin feels so soft and hydrated, and the scent is absolutely divine. A little goes a long way, so it's great value for money. Highly recommend!",
                rating: 4,
                product_name: "Body Cream",
                created_at: "2024-01-25",
                image: null
            },
            {
                id: 4,
                name: "Jordana",
                title: "Always moisturized body cream",
                review: "This body butter is a game-changer! My skin feels so soft and hydrated, and the scent is absolutely divine. A little goes a long way, so it's great value for money. Highly recommend!",
                rating: 4,
                product_name: "Body Cream",
                created_at: "2024-02-01",
                image: null
            }
        ];

        let currentReviews = sampleReviews;
        let currentPage = 1;
        const reviewsPerPage = 6;
        let selectedRating = 0;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadReviews();
            setupEventListeners();
            populateProductFilter();
        });

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function(e) {
                filterReviews();
            });

            // Product filter
            document.getElementById('productFilter').addEventListener('change', function(e) {
                filterReviews();
            });

            // Star rating in modal
            document.querySelectorAll('.star-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const rating = parseInt(this.dataset.rating);
                    setRating(rating);
                });
            });

            // Review form submission
            document.getElementById('reviewForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitReview();
            });
        }

        function loadReviews() {
            // Show loading state
            document.getElementById('loadingState').style.display = 'flex';
            document.getElementById('reviewsGrid').style.display = 'none';
            document.getElementById('emptyState').style.display = 'none';

            // Simulate API call - replace with actual fetch to your Laravel endpoint
            setTimeout(() => {
                displayReviews();
                document.getElementById('loadingState').style.display = 'none';
            }, 500);
        }

        function displayReviews() {
            const grid = document.getElementById('reviewsGrid');
            
            if (currentReviews.length === 0) {
                document.getElementById('emptyState').style.display = 'block';
                return;
            }

            const startIndex = (currentPage - 1) * reviewsPerPage;
            const endIndex = startIndex + reviewsPerPage;
            const pageReviews = currentReviews.slice(startIndex, endIndex);

            grid.innerHTML = pageReviews.map(review => createReviewCard(review)).join('');
            grid.style.display = 'grid';
            
            updatePagination();
        }

        function createReviewCard(review) {
            const stars = generateStars(review.rating);
            const initials = review.name.split(' ').map(n => n[0]).join('').substring(0, 2);
            const age = Math.floor(Math.random() * 30) + 20; // Random age for demo
            
            return `
                <div class="review-card bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            ${initials}
                        </div>
                        <div class="ml-3">
                            <h4 class="font-semibold text-gray-800">${review.name}, ${age}</h4>
                        </div>
                    </div>
                    
                    <h3 class="font-semibold text-gray-800 mb-2">${review.title}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-4">${review.review}</p>
                    
                    <div class="flex items-center">
                        ${stars}
                    </div>
                </div>
            `;
        }

        function generateStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<span class="star-rating text-lg">★</span>';
                } else {
                    stars += '<span class="star-empty text-lg">★</span>';
                }
            }
            return stars;
        }

        function filterReviews() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const productFilter = document.getElementById('productFilter').value;
            
            currentReviews = sampleReviews.filter(review => {
                const matchesSearch = review.product_name.toLowerCase().includes(searchTerm) || 
                                    review.title.toLowerCase().includes(searchTerm) ||
                                    review.review.toLowerCase().includes(searchTerm);
                const matchesProduct = !productFilter || review.product_name === productFilter;
                
                return matchesSearch && matchesProduct;
            });
            
            currentPage = 1;
            displayReviews();
        }

        function populateProductFilter() {
            const products = [...new Set(sampleReviews.map(review => review.product_name))];
            const select = document.getElementById('productFilter');
            
            products.forEach(product => {
                const option = document.createElement('option');
                option.value = product;
                option.textContent = product;
                select.appendChild(option);
            });
        }

        function updatePagination() {
            const totalPages = Math.ceil(currentReviews.length / reviewsPerPage);
            const pagination = document.getElementById('pagination');
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            // Previous button
            if (currentPage > 1) {
                paginationHTML += `<button onclick="changePage(${currentPage - 1})" class="px-3 py-1 text-gray-600 hover:text-purple-600">← Previous</button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'bg-purple-600 text-white' : 'text-gray-600 hover:text-purple-600';
                paginationHTML += `<button onclick="changePage(${i})" class="px-3 py-1 rounded ${activeClass}">${i}</button>`;
            }
            
            // Next button
            if (currentPage < totalPages) {
                paginationHTML += `<button onclick="changePage(${currentPage + 1})" class="px-3 py-1 text-gray-600 hover:text-purple-600">Next →</button>`;
            }
            
            pagination.innerHTML = paginationHTML;
        }

        function changePage(page) {
            currentPage = page;
            displayReviews();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function openReviewModal() {
            document.getElementById('reviewModal').style.display = 'flex';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
            setRating(0);
        }

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('selectedRating').value = rating;
            
            document.querySelectorAll('.star-btn').forEach((btn, index) => {
                if (index < rating) {
                    btn.classList.add('star-rating');
                    btn.classList.remove('star-empty');
                } else {
                    btn.classList.add('star-empty');
                    btn.classList.remove('star-rating');
                }
            });
        }

        function submitReview() {
            const formData = new FormData(document.getElementById('reviewForm'));
            
            // In a real application, you would send this to your Laravel backend
            // fetch('/api/reviews', {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     }
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         alert('Review submitted successfully!');
            //         closeReviewModal();
            //         loadReviews();
            //     }
            // })
            // .catch(error => {
            //     console.error('Error:', error);
            //     alert('Error submitting review. Please try again.');
            // });

            // For demo purposes
            alert('Review submitted successfully! (This is a demo - integrate with your Laravel backend)');
            closeReviewModal();
        }

        // Style the star buttons
        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.classList.add('star-empty');
        });
    </script>
</body>
</html>