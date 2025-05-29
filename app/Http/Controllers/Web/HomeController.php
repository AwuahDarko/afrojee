<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index(){
        $featured_products = Product::with('Category')->where(['featured' => 1])->limit(4)->get();

        return view('frontend.index', compact('featured_products'));
    }
}
