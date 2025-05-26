<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Faker\Extension\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

        $products = Product::all();

        return view('backend.products', compact('products'));
    }

    public function newProduct(){
        $categories = Category::where(['status' => 1])->get();

        return view('backend.new-product', compact('categories'));
    }

     public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category' => 'required',
             'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'required',
            'how_to_use' => 'required',
            'ingredients' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }

         $filePath = "";
        // Handle the uploaded file
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // Optional: give the file a unique name
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();

        // Move it to public/uploads
        $image->move(public_path('uploads'), $filename);

        // Return the relative path (or full URL if needed)
        $filePath = asset('uploads/' . $filename);
        // Or use: asset('uploads/' . $filename) for full URL
    }


        $product = new Product(
            [
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category,
                'image' =>  $filePath,
                'description'=> $request->description,
                'how_to_use' => $request->how_to_use,
                'ingredients' => $request->ingredients,
                'slug' => generateUuidV4()     
            ]
        );
        $product->save();

        return redirect()->intended(route('admin.products'));

    }
}
