<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Add this use statement

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // Start with all approved reviews
        $query = Review::approved()
            ->select(['id', 'name', 'product_name', 'title', 'review', 'rating', 'image'])
            ->latest();

        // Implement Product Name Filter
        if ($request->filled('product_name')) {
            $query->where('product_name', $request->product_name);
        }
        // Implement Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->where('status', 'approved')
                    ->orWhere('review', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        // Paginate the results
        $reviews = $query->paginate(5); // You can adjust the number per page (e.g., 5, 10, 12)

        // Get unique product names for the filter dropdown
        $productNames = Review::approved()->distinct()->pluck('product_name')->filter()->sort();

        // Get stats (optional, for display if needed)
        $stats = [
            'total_reviews' => Review::approved()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0,
            'featured_count' => Review::featured()->count()
        ];

        return view('frontend.partials.all-reviews', compact('reviews', 'productNames', 'stats'));
    }

    /**
     * Display the form to create a new review.
     */
    public function create()
    {
        // You might want to pass some data to the form, e.g., a list of products
        $availableProducts = Review::approved()->distinct()->pluck('product_name')->filter()->sort();
        return view('frontend.partials.review-form', compact('availableProducts'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'product_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image upload
            // 'age' => 'nullable|integer|min:1', // Add if you want to capture age
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
            $validated['image'] = basename($imagePath);
        }

        // Set status to 'pending' by default for frontend submissions
        $validated['status'] = 'pending';
        $validated['is_featured'] = false; // Not featured by default from frontend

        Review::create($validated);

        return redirect()->route('reviews')->with('success', 'Your review has been submitted for approval!');
    }


    /**
     * Get featured reviews for AJAX requests or API - no changes needed here unless you want to filter this endpoint too.
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
     * Show all approved reviews (for "View All Reviews" link) -
     * This method is now effectively merged into the index method for simplicity.
     * You might remove this if your main reviews page handles all filtering/pagination.
     */
    public function allReviews()
    {
        // This method is now largely redundant if index() handles all review display.
        // You can redirect to index() or remove this method.
        return redirect()->route('reviews');
    }
}