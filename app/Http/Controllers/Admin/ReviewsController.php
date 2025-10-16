<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
//reviews controller for admin
class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'approvedBy'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('review', 'like', "%{$search}%")
                    ->orWhereHas('product', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->paginate(15)->appends($request->all());

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
        $stats = [
            'total' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
            'featured' => Review::featured()->count(),
            'average_rating' => Review::approved()->avg('rating') ?? 0
        ];
        
        $products = Product::where('status', 1)->orderBy('name')->get();
        return view('backend.create-reviews', compact('stats', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'is_featured' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/reviews');

            // Create uploads/reviews directory if it doesn't exist
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }

            // Generate a unique filename and move the file
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            
            // Store just the filename in the database
            $validated['image'] = $filename;
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
        $review->load(['approvedBy', 'product']);
        return view('backend.reviews-show', compact('review'));
    }

    public function edit(Review $review)
    {
        $products = Product::where('status', 1)->orderBy('name')->get();
        return view('backend.edit-reviews', compact('review', 'products'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'is_featured' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/reviews');

            // 1. Delete old image if it exists
            if ($review->image && File::exists("{$uploadDir}/{$review->image}")) {
                File::delete("{$uploadDir}/{$review->image}");
            }
            
            // 2. Create uploads/reviews directory if it doesn't exist
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }

            // 3. Generate a unique filename and move the file
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            // 4. Store the new filename in the database
            $validated['image'] = $filename;

        } elseif ($request->input('clear_image')) {
            // Optional: Handle case where an existing image is explicitly cleared (e.g., via a checkbox)
            if ($review->image && File::exists(public_path('uploads/reviews/' . $review->image))) {
                File::delete(public_path('uploads/reviews/' . $review->image));
            }
            $validated['image'] = null;
        } else {
            // Ensure image field is not unintentionally cleared if no new file is uploaded
            unset($validated['image']);
        }

        // Handle status change logic
        if ($validated['status'] === 'approved' && $review->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        } elseif ($validated['status'] !== 'approved') {
            $validated['approved_at'] = null;
            $validated['approved_by'] = null;
        }

        $review->update($validated);

        return redirect()->route('admin.reviews')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $uploadDir = public_path('uploads/reviews');

        // Delete image if exists
        if ($review->image && File::exists("{$uploadDir}/{$review->image}")) {
            File::delete("{$uploadDir}/{$review->image}");
        }

        $review->delete();

        return redirect()->route('admin.reviews')
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
                $uploadDir = public_path('uploads/reviews');
                // Delete images using the new file path convention
                $reviewsToDelete = $reviews->get();
                foreach ($reviewsToDelete as $review) {
                    if ($review->image && File::exists("{$uploadDir}/{$review->image}")) {
                        File::delete("{$uploadDir}/{$review->image}");
                    }
                }
                $reviews->delete();
                $message = 'Reviews deleted successfully.';
                break;
        }

        return redirect()->route('admin.reviews')->with('success', $message);
    }
}