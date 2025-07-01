{{-- resources/views/frontend/reviews.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Customer Reviews')

@section('content')
<style>
        .star-rating .star {
            color: #FFD700; /* Gold color for stars */
            font-size: 1.5rem;
        }
        .mmax-container {
            max-width: 1200px; /* Adjust as needed */
        }
        .mmax-products {
            max-width: 300px; /* Adjust as needed for the heading underline */
        }
        .text-taupe {
            color: #4A443B; /* Example taupe color */
        }
        .bg-taupe {
            background-color: #4A443B; /* Example taupe color */
        }
        .bg-mauve {
            background-color: #9C2758; /* Example mauve color */
        }
    </style>
     <section class="py-16 px-4 md:px-8">
        <div class="container mx-auto mmax-container">
            <div class="mb-12">
                <div class="flex items-center mmax-products mb-2">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-light text-taupe mb-2">
                        Read <br><span class="font-bold">Our Reviews</span>
                    </h2>
                    <div class="bg-taupe h-1 backdrop-blur-sm w-full min-w-lg mt-4 mb-8"></div>
                </div>
                <p class="text-taupe text-lg md:text-xl max-w-4xl">
                    Don't just take our word for it—see what our customers are saying about their experience!
                </p>
            </div>

            <form action="{{ route('reviews') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between mb-8 space-y-4 md:space-y-0 md:space-x-4">
                <div class="relative w-full md:w-auto flex-grow">
                    <input type="text" name="search" placeholder="Enter product to search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-taupe" aria-label="Search reviews" value="{{ request('search') }}">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                    <button type="submit" class="hidden bg-mauve text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-colors duration-300 flex-shrink-0">
                        All Reviews
                    </button>
                    <div class="relative inline-block text-left w-full md:w-auto">
                        <select name="product_name" onchange="this.form.submit()" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">Select Product</option>
                            @foreach($productNames as $productName)
                                <option value="{{ $productName }}" {{ request('product_name') == $productName ? 'selected' : '' }}>
                                    {{ $productName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <a href="{{ route('reviews.create') }}" class="bg-mauve text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-colors duration-300 flex items-center justify-center flex-shrink-0">
                        Leave a Review
                        <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </form>

            <div class="reviews">
                <h3 class="text-3xl font-bold text-taupe mb-6">Reviews</h3>

                @if($reviews->isEmpty())
                    <p class="text-gray-600">No reviews available matching your criteria.</p>
                @else
                    @foreach($reviews as $review)
                        <div class="review-item bg-white p-6 rounded-lg shadow-md mb-6">
                            <div class="flex items-center mb-3">
                                @if($review->image)
                                    <img src="{{ asset('storage/reviews/' . $review->image) }}" alt="{{ $review->name }}" class="w-12 h-12 rounded-full object-cover mr-4">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-xl mr-4">
                                        {{ substr($review->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-lg text-gray-800">{{ $review->name }}, {{ $review->age ?? '' }}</p>
                                    @if($review->product_name)
                                        <p class="text-gray-600 text-sm italic">{{ $review->product_name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="star-rating mb-3">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <span class="star">&#9733;</span>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <span class="star text-gray-300">&#9733;</span>
                                @endfor
                            </div>
                            <p class="text-gray-700 text-base leading-relaxed">
                                <span class="font-medium">{{ $review->title }}</span><br>
                                {{ $review->review }}
                            </p>
                        </div>
                    @endforeach
                @endif

                <div class="mt-8">
                    {{ $reviews->appends(request()->input())->links() }}
                </div>

            </div>
        </div>
    </section>
@endsection