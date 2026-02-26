<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\FreeDeliverySetting;
use Illuminate\Http\Request;

class FreeDeliverySettingController extends Controller
{
    /**
     * Show the free delivery settings form.
     */
    public function index()
    {
        $settings = FreeDeliverySetting::get();
        $countries = Country::where('status', 1)->orderBy('name')->get();
        return view('backend.free-delivery-settings', compact('settings', 'countries'));
    }

    /**
     * Update free delivery settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'enabled' => 'nullable|in:1,on',
            'min_order_amount' => 'required|numeric|min:0',
            'country_ids' => 'nullable|array',
            'country_ids.*' => 'integer|exists:countries,id',
        ], [
            'min_order_amount.required' => 'Minimum order amount is required.',
            'min_order_amount.min' => 'Minimum order amount must be 0 or greater.',
        ]);

        $settings = FreeDeliverySetting::get();
        $settings->enabled = $request->has('enabled');
        $settings->min_order_amount = $request->input('min_order_amount', 0);
        $settings->country_ids = $request->input('country_ids', []);
        $settings->save();

        return redirect()->route('admin.free-delivery.index')
            ->with('success', 'Free delivery settings saved.');
    }
}
