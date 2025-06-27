<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Get only featured and approved reviews
        $featuredReviews = Review::where('is_featured', true)
            ->where('status', 'approved')
            ->with('approvedBy')
            ->latest()
            ->get();

        // Get stats for potential display
        $stats = [
            'total_reviews' => Review::approved()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0,
            'featured_count' => $featuredReviews->count()
        ];

        return view('frontend.reviews', compact('featuredReviews', 'stats'));
    }

    /**
     * Get featured reviews for AJAX requests or API
     */
    public function getFeaturedReviews()
    {
        $featuredReviews = Review::where('is_featured', true)
            ->where('status', 'approved')
            ->select(['id', 'name', 'title', 'review', 'rating', 'image', 'product_name'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'reviews' => $featuredReviews,
            'count' => $featuredReviews->count()
        ]);
    }

    /**
     * Show all approved reviews (for "View All Reviews" link)
     */
    public function allReviews()
    {
        $reviews = Review::approved()
            ->with('approvedBy')
            ->latest()
            ->paginate(12);

        $stats = [
            'total_reviews' => Review::approved()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0,
            'featured_count' => Review::featured()->count()
        ];

        return view('frontend.all-reviews', compact('reviews', 'stats'));
    }
}
