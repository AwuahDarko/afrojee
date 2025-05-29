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
    public function index()
    {

        $products = Product::with('category')->orderBy('name', 'asc')->paginate(30);

        return view('backend.products', compact('products'));
    }

    public function newProduct()
    {
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
            'weight' => 'required',
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
                'image' => $filePath,
                'description' => $request->description,
                'how_to_use' => $request->how_to_use,
                'ingredients' => $request->ingredients,
                'slug' => generateUuidV4(),
                'weight' => $request->weight
            ]
        );
        $product->save();

        return redirect()->intended(route('admin.products'));

    }

    public function viewProduct(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        // dd($product->category_id);
        $categories = Category::where(['status' => 1])->get();

        return view('backend.edit-product', compact('product', 'categories'));
    }

    public function activate(Request $request)
    {


        if (!$request->id) {
            abort(404);
        }

        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        $product->status = 1;

        $product->save();

        return redirect()->intended(route('admin.products'));
    }

    public function deactivate(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }


        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        $product->status = 0;

        $product->save();

        return redirect()->intended(route('admin.products'));
    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'category' => 'required',
            //  'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'required',
            'how_to_use' => 'required',
            'ingredients' => 'required',
            'weight' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }

        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
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

            $product->image = $filePath;
        }


        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->how_to_use = $request->how_to_use;
        $product->ingredients = $request->ingredients;
        $product->weight = $request->weight;
        
        $product->save();

        return redirect()->intended(route('admin.products'));
    }

     public function feature(Request $request)
    {


        if (!$request->id) {
            abort(404);
        }

        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        $product->featured = 1;

        $product->save();

        return redirect()->intended(route('admin.products'));
    }

    public function remove(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }


        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        $product->featured = 0;

        $product->save();

        return redirect()->intended(route('admin.products'));
    }

}

