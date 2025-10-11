<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'sizes'])->orderBy('name', 'asc')->paginate(30);
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
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'required',
            'how_to_use' => 'required',
            'ingredients' => 'required',
            'weight' => 'required|numeric|min:0',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.price' => 'required_with:sizes.*.size|numeric|min:0',
            'sizes.*.quantity' => 'required_with:sizes.*.size|integer|min:0',
            'sizes.*.weight' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }

        $filePath = "";
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename);
            $filePath = asset('uploads/' . $filename);
        }

        $product = new Product([
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
        ]);
        $product->save();

        // Save sizes if provided
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                if (!empty($sizeData['size'])) {
                    ProductSize::create([
                        'product_id' => $product->id,
                        'size' => $sizeData['size'],
                        'price' => $sizeData['price'],
                        'quantity' => $sizeData['quantity'],
                        'weight' => $sizeData['weight'] ?? null
                    ]);
                }
            }
        }

        return redirect()->intended(route('admin.products'))->with('success', 'Product created successfully');
    }

    public function viewProduct(Request $request)
    {
        $product = Product::with('sizes')->find($request->id);
        if (!$product) {
            abort(404);
        }
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
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'required',
            'how_to_use' => 'required',
            'ingredients' => 'required',
            'weight' => 'required|numeric|min:0',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.price' => 'required_with:sizes.*.size|numeric|min:0',
            'sizes.*.quantity' => 'required_with:sizes.*.size|integer|min:0',
            'sizes.*.weight' => 'nullable|numeric|min:0',
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

        $filePath = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $filename);
            $filePath = asset('Uploads/' . $filename);
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

        // Update sizes
        $existingSizeIds = $product->sizes()->pluck('id')->toArray();
        $submittedSizeIds = array_filter(array_column($request->sizes ?? [], 'id', 'id'));

        // Delete sizes that are no longer in the request
        $sizesToDelete = array_diff($existingSizeIds, $submittedSizeIds);
        ProductSize::whereIn('id', $sizesToDelete)->delete();

        // Update or create sizes
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                if (!empty($sizeData['size'])) {
                    ProductSize::updateOrCreate(
                        ['id' => $sizeData['id'] ?? null, 'product_id' => $product->id],
                        [
                            'size' => $sizeData['size'],
                            'price' => $sizeData['price'],
                            'quantity' => $sizeData['quantity'],
                            'weight' => $sizeData['weight'] ?? null
                        ]
                    );
                }
            }
        }

        return redirect()->intended(route('admin.products'))->with('success', 'Product updated successfully');
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

    public function delete(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }
        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }
        if ($product->image && file_exists(public_path(parse_url($product->image, PHP_URL_PATH)))) {
            unlink(public_path(parse_url($product->image, PHP_URL_PATH)));
        }
        $product->delete();
        return redirect()->intended(route('admin.products'))->with('success', 'Product deleted successfully');
    }
}
