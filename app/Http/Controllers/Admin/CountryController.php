<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CountryController extends Controller
{
    public function index(){
        $countries = Country::all();

        return view('backend.countries', compact('countries'));
    }


     public function newCountry()
    {

        return view('backend.new-country', );
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


        $category = new Country(
            [
                'name' => $request->name,
                // 'slug' => strtolower(implode('-',explode(' ', $request->name)))
            ]
        );
        $category->save();

        return redirect()->intended(route('admin.countries'));

    }

    public function viewCountry(Request $request)
    {
        // dd($request->id);
        $country = Country::find($request->id);
        if (!$country) {
            abort(404);
        }
        return view('backend.edit-country', compact('country'));
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


        $country = Country::find($request->id);
        if (!$country) {
            abort(404);
        }

        $country->name = $request->name;
        // $country->slug = strtolower(implode('-',explode(' ', $request->name)));

        $country->save();

        return redirect()->intended(route('admin.countries'));

    }

    public function activate(Request $request)
    {
      

        if (!$request->id) {
            abort(404);
        }

        $country = Country::find($request->id);
        if (!$country) {
            abort(404);
        }

        $country->status = 1;

        $country->save();

        return redirect()->intended(route('admin.countries'));
    }

    public function deactivate(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }


        $country = Country::find($request->id);
        if (!$country) {
            abort(404);
        }

        $country->status = 0;

        $country->save();

        return redirect()->intended(route('admin.countries'));
    }

}
