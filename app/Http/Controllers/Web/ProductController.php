<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    private int $items_per_page = 15;

    public function index(Request $request)
    {
        $categories = Category::where('status', '=', 1)->get();
        $products = Product::where('status', '=', 1)->with([
            'category',
            'sizes',
            'images' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->paginate($this->items_per_page);

        return view('frontend.partials.productList', compact('categories', 'products'));
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

    public function productDetails(Request $request)
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
            ])
            ->firstOrFail();

        $primaryImagePath = $product->getPrimaryImage()?->image_path ?? 
                        ($product->images->first()?->image_path ?? asset('images/default-product.jpg'));

        $clean_description = strip_tags($product->description);
        $meta_description = substr($clean_description, 0, strlen($clean_description) / 2);
        $meta_keywords = $product->name;

        return view('frontend.partials.productDetail', compact('product', 'meta_description', 'meta_keywords', 'primaryImagePath'));
    }
}