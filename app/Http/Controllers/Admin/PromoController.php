<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\PromoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('backend.promo', compact('promos'));
    }


    public function create()
    {
        $products = Product::where('status', '=', 1)->get();
        return view('backend.new-promo', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startdate' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
            'endtime' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'products' => 'required|string|min:1',

        ]);

        $productIds = explode(',', $request->products);

        $promo = Promo::create([
            'name' => $request->name,
            'start_at' => $request->startdate . ' ' . $request->starttime,
            'end_at' => $request->enddate . ' ' . $request->endtime,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
        ]);

        foreach ($productIds as $id) {
            PromoProduct::create([
                'product_id' => trim($id),
                'promo_id' => $promo->id
            ]);
        }



        return redirect()->intended(route('admin.promos'));

    }

    public function viewPromo(Request $request)
    {
        $promo = Promo::with('promoProducts')->where('id', '=', $request->id)->first();
        if (!$promo) {
            abort(404);
        }

        $productIdArr = $promo->promoProducts->map(function ($one) {
            return $one->product_id;
        })->toArray();
        $productNames = $promo->promoProducts->map(function ($one) {
            return $one->product->name;
        })->toArray();


        $productIds = implode(',', $productIdArr, );
        $productNameArr = implode(',', $productNames, );
        // dd($productNames);



        $products = Product::where('status', '=', 1)->get();
        return view('backend.edit-promo', compact('promo', 'products', 'productIdArr', 'productIds', 'productNames'));

    }


    public function activate(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }

        $promo = Promo::find($request->id);
        if (!$promo) {
            abort(404);
        }

        $promo->status = 1;

        $promo->save();

        return redirect()->intended(route('admin.promos'));
    }

    public function deactivate(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }


        $promo = Promo::find($request->id);
        if (!$promo) {
            abort(404);
        }

        $promo->status = 0;

        $promo->save();

        return redirect()->intended(route('admin.promos'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startdate' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
            'endtime' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'products' => 'required|string|min:1',

        ]);

        $productIds = explode(',', $request->products);

        $promo = Promo::find($request->id);
        if (!$promo) {
            abort(404);
        }

        $promo->name = $request->name;
        $promo->start_at = $request->startdate . ' ' . $request->starttime;
        $promo->end_at = $request->enddate . ' ' . $request->endtime;
        $promo->discount = $request->discount;
        $promo->discount_type = $request->discount_type;
        $promo->save();

        PromoProduct::where('promo_id', '=', $request->id)->delete(); 

        foreach ($productIds as $id) {
            PromoProduct::create([
                'product_id' => trim($id),
                'promo_id' => $promo->id
            ]);
        }

        return redirect()->intended(route('admin.promos'));
    }
}
