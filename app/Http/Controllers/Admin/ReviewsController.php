<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('approvedBy')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('review', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15)->appends($request->all());

        // Stats for dashboard
        $stats = [
            'total' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
            'featured' => Review::featured()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0
        ];

        return view('backend.reviews', compact('reviews', 'stats'));
    }

    public function create()
    {
        // Get stats for the dashboard cards
        $stats = [
            'total' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
            'featured' => Review::featured()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0
        ];
        $reviews = Review::with('approvedBy')->latest()->paginate(15);
        return view('backend.create-reviews', compact('stats', 'reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'product_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'is_featured' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
            $validated['image'] = basename($imagePath);
        }

        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        Review::create($validated);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review created successfully.');
    }

    public function show(Review $review)
    {
        $review->load('approvedBy');
        return view('backend.reviews-show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('backend.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'product_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($review->image) {
                Storage::disk('public')->delete('reviews/' . $review->image);
            }

            $imagePath = $request->file('image')->store('reviews', 'public');
            $validated['image'] = basename($imagePath);
        }

        // Handle status change
        if ($validated['status'] === 'approved' && $review->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        } elseif ($validated['status'] !== 'approved') {
            $validated['approved_at'] = null;
            $validated['approved_by'] = null;
        }

        $review->update($validated);

        return redirect()->route('backend.reviews')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete image if exists
        if ($review->image) {
            Storage::disk('public')->delete('reviews/' . $review->image);
        }

        $review->delete();

        return redirect()->route('backend.reviews')
            ->with('success', 'Review deleted successfully.');
    }

    // Quick Actions
    public function approve(Review $review)
    {
        $review->approve();

        return response()->json([
            'success' => true,
            'message' => 'Review approved successfully.',
            'status' => $review->status_badge
        ]);
    }

    public function reject(Review $review)
    {
        $review->reject();

        return response()->json([
            'success' => true,
            'message' => 'Review rejected successfully.',
            'status' => $review->status_badge
        ]);
    }

    public function toggleFeatured(Review $review)
    {
        $review->toggleFeatured();

        return response()->json([
            'success' => true,
            'message' => $review->is_featured ? 'Review marked as featured.' : 'Review removed from featured.',
            'is_featured' => $review->is_featured
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,feature,unfeature',
            'reviews' => 'required|array',
            'reviews.*' => 'exists:reviews,id'
        ]);

        $reviews = Review::whereIn('id', $request->reviews);

        switch ($request->action) {
            case 'approve':
                $reviews->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id()
                ]);
                $message = 'Reviews approved successfully.';
                break;

            case 'reject':
                $reviews->update([
                    'status' => 'rejected',
                    'approved_at' => null,
                    'approved_by' => null
                ]);
                $message = 'Reviews rejected successfully.';
                break;

            case 'feature':
                $reviews->update(['is_featured' => true]);
                $message = 'Reviews marked as featured.';
                break;

            case 'unfeature':
                $reviews->update(['is_featured' => false]);
                $message = 'Reviews removed from featured.';
                break;

            case 'delete':
                // Delete images
                $reviewsToDelete = $reviews->get();
                foreach ($reviewsToDelete as $review) {
                    if ($review->image) {
                        Storage::disk('public')->delete('reviews/' . $review->image);
                    }
                }
                $reviews->delete();
                $message = 'Reviews deleted successfully.';
                break;
        }

        return redirect()->route('backend.reviews')->with('success', $message);
    }
}