<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('backend.categories', compact('categories'));
    }


    public function newCategory()
    {

        return view('backend.new-category', );
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }


        $category = new Category(
            [
                'name' => $request->name,
                'slug' => strtolower(implode('-',explode(' ', $request->name)))
            ]
        );
        $category->save();

        return redirect()->intended(route('admin.categories'));

    }

    public function viewCategory(Request $request)
    {
        // dd($request->id);
        $category = Category::find($request->id);
        if (!$category) {
            abort(404);
        }
        return view('backend.edit-category', compact('category'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }


        $category = Category::find($request->id);
        if (!$category) {
            abort(404);
        }

        $category->name = $request->name;
        $category->slug = strtolower(implode('-',explode(' ', $request->name)));

        $category->save();

        return redirect()->intended(route('admin.categories'));

    }

    public function activate(Request $request)
    {
      

        if (!$request->id) {
            abort(404);
        }

        $category = Category::find($request->id);
        if (!$category) {
            abort(404);
        }

        $category->status = 1;

        $category->save();

        return redirect()->intended(route('admin.categories'));
    }

    public function deactivate(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }


        $category = Category::find($request->id);
        if (!$category) {
            abort(404);
        }

        $category->status = 0;

        $category->save();

        return redirect()->intended(route('admin.categories'));
    }
}
