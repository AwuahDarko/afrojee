<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request){
        $categories = Category::where('status', 1)->get();
        $products = Product::where('status', 1)->with('category')->get();

        return view('frontend.partials.productList', compact('categories', 'products'));
    
        // return view('frontend.partials.productList');
    }
}
