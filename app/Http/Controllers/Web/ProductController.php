<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    private int $items_per_page = 15;

    // public function index(Request $request)
    // {
    //     $categories = Category::where('status', '=', 1)->get();
    //     $products = Product::where('status', '=', 1)->with([
    //         'category',
    //         'sizes',
    //         'images' => function ($query) {
    //             $query->orderBy('sort_order');
    //         }
    //     ])->paginate($this->items_per_page);

    //     return view('frontend.partials.productList', compact('categories', 'products'));
    // }
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images' => function ($query) {
            $query->orderBy('sort_order')->take(2); // Load primary and secondary images
        }])
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->paginate(12); // Adjust per page as needed

        return view('frontend.partials.productList', compact('products'));
    }
    public function filterByCategory(Request $request)
    {
        $slug = $request->slug;

        $category = Category::where(['status' => 1, 'slug' => $slug])->firstOrFail();

        $categories = Category::where('status', '=', 1)->get();
        $products = Product::where(['status' => 1, 'category_id' => $category->id])
            ->with([
                'category',
                'sizes',
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                }
            ])
            ->paginate($this->items_per_page);

        return view('frontend.partials.productList', compact('categories', 'products'));
    }

    public function search(Request $request)
    {
        $search = $request->q;

        $categories = Category::where('status', '=', 1)->get();

        $products = Product::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('ingredients', 'like', '%' . $search . '%')
                ->orWhere('how_to_use', 'like', '%' . $search . '%');
        })->with([
                    'category',
                    'sizes',
                    'images' => function ($query) {
                        $query->orderBy('sort_order');
                    }
                ])->paginate($this->items_per_page);

        return view('frontend.partials.productList', compact('categories', 'products'));
    }

    public function search2(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with(['images' => function ($query) {
            $query->orderBy('sort_order')->first();
        }])
            ->where('name', 'like', "%{$query}%")
            ->where('status', 1)
            ->take(5) // Limit to 5 results like Shopify
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => number_format($product->price, 2),
                    'compare_at_price' => $product->compare_at_price ? number_format($product->compare_at_price, 2) : null,
                    'image' => $product->images->first() ? asset('storage/' . $product->images->first()->path) : null,
                ];
            });

        return response()->json($products);
    }

    public function productDetails2(Request $request)
    {
        $slug = $request->slug;
        $product = Product::where('slug', '=', $slug)
            ->with([
                'sizes',
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                },
                'reviews' => function ($query) { // 🆕 REAL REVIEWS
                    $query->where('status', 'approved')
                        ->orderBy('is_featured', 'desc') // Featured first
                        ->orderBy('created_at', 'desc');
                }
            ])->withCount('reviews')->withAvg('reviews', 'rating')
            ->firstOrFail();

        $primaryImagePath = $product->getPrimaryImage()?->image_path ?? 
                        ($product->images->first()?->image_path ?? asset('images/default-product.png'));

        $clean_description = strip_tags($product->description);
        $meta_description = substr($clean_description, 0, strlen($clean_description) / 2);
        $meta_keywords = $product->name;
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->with(['images' => function ($query) {
                $query->orderBy('sort_order')->take(1); // Load primary image
            }])
            ->inRandomOrder()
            ->take(4)
            ->get();


        return view('frontend.partials.productDetail', compact('product', 'meta_description', 'meta_keywords', 'primaryImagePath', 'relatedProducts'));
    }

    public function productDetails(Request $request)
    {
        $slug = $request->slug;

        // Load product with sizes, ordered images, and only approved reviews
        $product = Product::where('slug', '=', $slug)
            ->with([
                'sizes',
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                },
                'reviews' => function ($query) { // 🆕 REAL REVIEWS
                    $query->where('status', 'approved')
                        ->orderBy('is_featured', 'desc') // Featured first
                        ->orderBy('created_at', 'desc');
                }
            ])->withCount('reviews')->withAvg('reviews', 'rating')
            ->firstOrFail();

        // primary image fallback
        $primaryImagePath = $product->getPrimaryImage()?->image_path
                            ?? ($product->images->first()?->image_path ?? asset('images/default-product.png'));

        // meta
        $clean_description = strip_tags($product->description ?: '');
        $meta_description = substr($clean_description, 0, max(100, min(250, strlen($clean_description) / 2)));
        $meta_keywords = $product->name;

        // related products (small set)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->take(1);
            }])
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Pass product reviews JSON too (useful for your productDetail.js)
        $productReviews = $product->reviews->map(fn($r) => [
            'id' => $r->id,
            'name' => $r->name,
            'rating' => $r->rating,
            'title' => $r->title,
            'review' => $r->review,
            'image' => $r->image ? asset('uploads/reviews/'.$r->image) : null,
            'is_featured' => (bool)$r->is_featured,
            'created_at' => $r->created_at->toDateTimeString(),
        ]);

        return view('frontend.partials.productDetail', compact(
            'product',
            'meta_description',
            'meta_keywords',
            'primaryImagePath',
            'relatedProducts',
            'productReviews'
        ));
    }

    public function storeReview(Request $request, Product $product)
    {

        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'review' => 'required|string|max:2000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imageName = uniqid() . '.' . $request->file('image_file')->getClientOriginalExtension();
            // Store image in public/uploads/reviews folder
            $request->file('image_file')->move(public_path('uploads/reviews'), $imageName);
            $imagePath = $imageName;
        }

        // 2. Create Review
        Review::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'title' => $request->title,
            'review' => $request->review,
            'image' => $imagePath,
            'status' => 'pending', // Reviews should be manually approved
        ]);
        // 3. Redirect with success message
        return back()->with('success', 'Your review has been submitted for approval. Thank you!');
    }
}