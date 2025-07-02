<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index(){
        $featured_products = Product::with('Category')->where(['featured' => 1])->limit(9)->get();
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
        return view('frontend.index', compact('featured_products', 'featuredReviews', 'stats'));
    }
}
