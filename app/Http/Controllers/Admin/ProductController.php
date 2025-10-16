<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'sizes', 'images' => function($query) {
            $query->orderBy('sort_order');
        }])->orderBy('name', 'asc')->paginate(30);
        return view('backend.products', compact('products'));
    }

    public function newProduct()
    {
        $categories = Category::where(['status' => 1])->get();
        return view('backend.new-product', compact('categories'));
    }

//     public function create(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'name' => 'required',
//             'price' => 'required|numeric|min:0',
//             'quantity' => 'required|integer|min:0',
//             'category' => 'required|exists:categories,id',
//             'images.*.file' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
//             'description' => 'required',
//             'how_to_use' => 'required',
//             'ingredients' => 'required',
//             'weight' => 'required|numeric|min:0',
//             'sizes.*.size' => 'nullable|string|max:255',
//             'sizes.*.price' => 'required_with:sizes.*.size|numeric|min:0',
//             'sizes.*.quantity' => 'required_with:sizes.*.size|integer|min:0',
//             'sizes.*.weight' => 'nullable|numeric|min:0',
//         ]);

//         if ($validator->fails()) {
//             return redirect()->back()
//                 ->withErrors($validator)
//                 ->withInput($request->only('name'));
//         }

//         $product = new Product([
//             'name' => $request->name,
//             'price' => $request->price,
//             'quantity' => $request->quantity,
//             'category_id' => $request->category,
//             'description' => $request->description,
//             'how_to_use' => $request->how_to_use,
//             'ingredients' => $request->ingredients,
//             'slug' => generateUuidV4(),
//             'weight' => $request->weight
//         ]);
//         $product->save();
// \Log::info('=== CREATE PRODUCT DEBUG ===', [
//         'product_id' => $product->id,
//         'images_input' => $request->images,
//         'primary_image' => $request->primary_image,
//         'has_images' => $request->hasFile('images')
//     ]);
//         // NEW: Handle Multiple Images
//         if ($request->hasFile('images')) {
//             foreach ($request->images as $index => $imageData) {
//                 if ($request->hasFile("images.{$index}.file")) {
//                     $file = $request->file("images.{$index}.file");
//                     $filename = uniqid() . '.' . $file->getClientOriginalExtension();
//                     $file->move(public_path('uploads/products'), $filename);
//                     $filePath = asset('uploads/products/' . $filename);

//                     $isPrimary = ($request->primary_image == $index) ? 1 : 0;
//                     $sortOrder = $request->input("images.{$index}.sort_order", $index);

//                     ProductImage::create([
//                         'product_id' => $product->id,
//                         'image_path' => $filePath,
//                         'is_primary' => $isPrimary,
//                         'sort_order' => $sortOrder
//                     ]);
//                 }
//             }
//         }

//         // Save sizes if provided
//         if ($request->has('sizes')) {
//             foreach ($request->sizes as $sizeData) {
//                 if (!empty($sizeData['size'])) {
//                     ProductSize::create([
//                         'product_id' => $product->id,
//                         'size' => $sizeData['size'],
//                         'price' => $sizeData['price'],
//                         'quantity' => $sizeData['quantity'],
//                         'weight' => $sizeData['weight'] ?? null
//                     ]);
//                 }
//             }
//         }

//         return redirect()->intended(route('admin.products'))->with('success', 'Product created successfully');
//     }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|exists:categories,id',
            'images.*.file' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
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

        // CREATE PRODUCT FIRST
        $product = new Product([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category,
            'description' => $request->description,
            'how_to_use' => $request->how_to_use,
            'ingredients' => $request->ingredients,
            'slug' => generateUuidV4(),
            'weight' => $request->weight
        ]);
        $product->save();

        // 🆕 FIXED DEBUG: Log what we're receiving
        // \Log::info('=== CREATE PRODUCT DEBUG ===', [
        //     'product_id' => $product->id,
        //     'images_input' => $request->images,
        //     'primary_image' => $request->primary_image,
        //     'has_images_array' => !empty($request->images) // ✅ CORRECT CHECK
        // ]);

        // 🆕 FIXED: Handle Multiple Images (CORRECT WAY)
        $imageCount = 0;
        if (!empty($request->images)) { // ✅ FIXED: Check array instead of hasFile
            foreach ($request->images as $index => $imageData) {
                // 🆕 CRITICAL: Check if file actually exists
                if (isset($imageData['file']) && $imageData['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $imageData['file']; // ✅ DIRECT ACCESS
                    
                    // 🆕 DEBUG: Log each file
                    // \Log::info("Processing image {$index}", [
                    //     'filename' => $file->getClientOriginalName(),
                    //     'size' => $file->getSize(),
                    //     'mime' => $file->getMimeType()
                    // ]);

                    try {
                        // Create uploads directory if it doesn't exist
                        $uploadDir = public_path('uploads/products');
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadDir, $filename);
                        $filePath = asset('uploads/products/' . $filename);

                        $isPrimary = ($request->primary_image == $index) ? 1 : 0;
                        $sortOrder = $request->input("images.{$index}.sort_order", $imageCount);

                        // 🆕 SAVE TO DB
                        $image = ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $filePath,
                            'is_primary' => $isPrimary,
                            'sort_order' => $sortOrder
                        ]);

                        // \Log::info("✅ Image saved", ['image_id' => $image->id, 'path' => $filePath]);
                        $imageCount++;

                    } catch (\Exception $e) {
                        \Log::error("❌ Image upload failed for {$index}", [
                            'error' => $e->getMessage(),
                            'filename' => $file->getClientOriginalName()
                        ]);
                    }
                }
            }
        }

        // \Log::info("=== CREATE COMPLETE ===", [
        //     'total_images_saved' => $imageCount,
        //     'product_id' => $product->id
        // ]);

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

        return redirect()->intended(route('admin.products'))->with('success', "Product created successfully with {$imageCount} images!");
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
            'images.*.file' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
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

        // 🆕 FIXED DEBUG LOG
        // \Log::info('=== UPDATE PRODUCT DEBUG ===', [
        //     'product_id' => $product->id,
        //     'images_input' => $request->images,
        //     'primary_image' => $request->primary_image,
        //     'has_images_array' => !empty($request->images) // ✅ CORRECT CHECK
        // ]);

        // 🆕 FIXED: Handle Multiple Images (CORRECT WAY)
        $imageCount = 0;
        if (!empty($request->images)) { // ✅ FIXED: Check array instead of hasFile
            // Delete old images if new ones are uploaded
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($request->images as $index => $imageData) {
                // 🆕 CRITICAL: Check if file actually exists
                if (isset($imageData['file']) && $imageData['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $imageData['file']; // ✅ DIRECT ACCESS
                    
                    // 🆕 DEBUG: Log each file
                    // \Log::info("Processing UPDATE image {$index}", [
                    //     'filename' => $file->getClientOriginalName(),
                    //     'size' => $file->getSize(),
                    //     'mime' => $file->getMimeType()
                    // ]);

                    try {
                        // Create uploads directory if it doesn't exist
                        $uploadDir = public_path('uploads/products');
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadDir, $filename);
                        $filePath = asset('uploads/products/' . $filename);

                        $isPrimary = ($request->primary_image == $index) ? 1 : 0;
                        $sortOrder = $request->input("images.{$index}.sort_order", $index);

                        // 🆕 SAVE TO DB
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $filePath,
                            'is_primary' => $isPrimary,
                            'sort_order' => $sortOrder
                        ]);

                        // \Log::info("✅ UPDATE Image saved", ['image_id' => $product->id, 'path' => $filePath]);
                        $imageCount++;

                    } catch (\Exception $e) {
                        \Log::error("❌ UPDATE Image upload failed for {$index}", [
                            'error' => $e->getMessage(),
                            'filename' => $file->getClientOriginalName()
                        ]);
                    }
                }
            }
        }

        // Update product details
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

        // \Log::info("=== UPDATE COMPLETE ===", [
        //     'total_images_saved' => $imageCount,
        //     'product_id' => $product->id
        // ]);

        return redirect()->intended(route('admin.products'))->with('success', "Product updated successfully with {$imageCount} new images!");
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

    // public function delete(Request $request)
    // {
    //     if (!$request->id) {
    //         abort(404);
    //     }
    //     $product = Product::find($request->id);
    //     if (!$product) {
    //         abort(404);
    //     }
    //     if ($product->image && file_exists(public_path(parse_url($product->image, PHP_URL_PATH)))) {
    //         unlink(public_path(parse_url($product->image, PHP_URL_PATH)));
    //     }
    //     $product->delete();
    //     return redirect()->intended(route('admin.products'))->with('success', 'Product deleted successfully');
    // }
    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            abort(404);
        }

        // NEW: Delete all product images
        foreach ($product->images as $image) {
            $path = public_path(parse_url($image->image_path, PHP_URL_PATH));
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $product->delete();
        return redirect()->intended(route('admin.products'))->with('success', 'Product deleted successfully');
    }
}
