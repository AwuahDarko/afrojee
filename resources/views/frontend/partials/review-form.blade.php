@extends('frontend.layouts.app')

@section('title')
    Afrojee - Review Form
@endsection

@section('content')
    <style>
        .text-taupe {
            color: #4A443B;
        }

        .bg-mauve {
            background-color: #9C2758;
        }

        .star-rating-input .star {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating-input .star.selected {
            color: #FFD700;
        }
    </style>
    <section class="container mx-auto max-w-2xl bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-4xl font-bold text-taupe mb-6">Leave a Review</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Your Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Your Email (Optional)</label>
                <input type="email" id="email" name="email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="product_name" class="block text-gray-700 text-sm font-bold mb-2">Product (Optional)</label>
                <select id="product_name" name="product_name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select a product (optional)</option>
                    @foreach($availableProducts as $product)
                        <option value="{{ $product }}" {{ old('product_name') == $product ? 'selected' : '' }}>{{ $product }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating <span
                        class="text-red-500">*</span></label>
                <div class="star-rating-input flex" id="star-rating-container">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Review Title <span
                        class="text-red-500">*</span></label>
                <input type="text" id="title" name="title"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('title') }}" required>
            </div>

            <div class="mb-6">
                <label for="review" class="block text-gray-700 text-sm font-bold mb-2">Your Review <span
                        class="text-red-500">*</span></label>
                <textarea id="review" name="review" rows="5"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>{{ old('review') }}</textarea>
            </div>

            <div class="mb-6 hidden">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Upload an Image (Optional)</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-mauve hover:bg-opacity-90 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-300">
                    Submit Review
                </button>
                <a href="{{ route('reviews') }}"
                    class="inline-block align-baseline font-bold text-sm text-taupe hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const starContainer = document.getElementById('star-rating-container');
            const ratingInput = document.getElementById('rating-input');
            const stars = starContainer.querySelectorAll('.star');

            function updateStars(rating) {
                stars.forEach(star => {
                    if (parseInt(star.dataset.value) <= rating) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = parseInt(this.dataset.value);
                    ratingInput.value = value;
                    updateStars(value);
                });

                star.addEventListener('mouseover', function () {
                    const value = parseInt(this.dataset.value);
                    stars.forEach(s => {
                        if (parseInt(s.dataset.value) <= value) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                });

                star.addEventListener('mouseout', function () {
                    updateStars(parseInt(ratingInput.value));
                });
            });

            // Set initial stars based on old input value if form reloads with errors
            updateStars(parseInt(ratingInput.value));
        });
    </script>
@endsection