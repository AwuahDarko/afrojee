<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\FreeDeliveryRule;
use App\Models\FreeDeliverySetting;
use Illuminate\Http\Request;

class FreeDeliverySettingController extends Controller
{
    /**
     * Show free delivery: global enable + list of rules + add form.
     */
    public function index()
    {
        $settings = FreeDeliverySetting::get();
        $rules = FreeDeliveryRule::with('country')->orderBy('id')->get();
        $countries = Country::where('status', 1)->orderBy('name')->get();
        $usedCountryIds = $rules->pluck('country_id')->all();
        return view('backend.free-delivery-settings', compact('settings', 'rules', 'countries', 'usedCountryIds'));
    }

    /**
     * Update global free delivery on/off only.
     */
    public function update(Request $request)
    {
        $request->validate([
            'enabled' => 'nullable|in:1,on',
        ]);
        $settings = FreeDeliverySetting::get();
        $settings->enabled = $request->has('enabled');
        $settings->save();
        return redirect()->route('admin.free-delivery.index')
            ->with('success', 'Free delivery setting saved.');
    }

    /**
     * Add a new rule (one country + min amount).
     */
    public function storeRule(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id|unique:free_delivery_rules,country_id',
            'min_order_amount' => 'required|numeric|min:0',
        ], [
            'country_id.unique' => 'A rule for this country already exists. Edit or remove it first.',
        ]);
        FreeDeliveryRule::create([
            'country_id' => $request->country_id,
            'min_order_amount' => $request->min_order_amount,
        ]);
        return redirect()->route('admin.free-delivery.index')
            ->with('success', 'Free delivery rule added.');
    }

    /**
     * Update an existing rule.
     */
    public function updateRule(Request $request, FreeDeliveryRule $rule)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id|unique:free_delivery_rules,country_id,' . $rule->id,
            'min_order_amount' => 'required|numeric|min:0',
        ]);
        $rule->update([
            'country_id' => $request->country_id,
            'min_order_amount' => $request->min_order_amount,
        ]);
        return redirect()->route('admin.free-delivery.index')
            ->with('success', 'Rule updated.');
    }

    /**
     * Delete a rule.
     */
    public function destroyRule(FreeDeliveryRule $rule)
    {
        $rule->delete();
        return redirect()->route('admin.free-delivery.index')
            ->with('success', 'Rule removed.');
    }
}
