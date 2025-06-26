<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    // Show all shipping zones and rates
    public function index()
    {
        $zones = ShippingZone::with('rates')->get();
        return view('backend.shipment', compact('zones'));
    }

    // Show form to create new shipping zone and rates
    public function create()
    {
        return view('backend.create-shipment');
    }

    // Store a new shipping zone with rates
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'region' => 'required|string|max:255', // Changed from 'city'
            'rates' => 'required|array',
            'rates.*.weight_from' => 'required|numeric', // Changed from min_weight
            'rates.*.weight_to' => 'required|numeric',   // Changed from max_weight
            'rates.*.rate' => 'required|numeric',
        ]);

        $zone = ShippingZone::create([
            'zone_name' => $request->zone_name,
            'region' => $request->region,
        ]);

        foreach ($request->rates as $rate) {
            $zone->rates()->create($rate);
        }

        return redirect()->route('admin.shipment')->with('success', 'Shipping zone and rates created.');
    }

    // Show form to edit existing zone and its rates
    public function edit($id)
    {
        $zone = ShippingZone::with('rates')->findOrFail($id);
        return view('backend.edit-shipment', compact('zone'));
    }

    // Update shipping zone and its rates
    public function update(Request $request, $id)
    {
        $zone = ShippingZone::findOrFail($id);

        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'rates' => 'required|array',
            'rates.*.weight_from' => 'required|numeric',
            'rates.*.weight_to' => 'required|numeric',
            'rates.*.rate' => 'required|numeric',
        ]);

        $zone->update([
            'zone_name' => $request->zone_name,
            'region' => $request->region,
        ]);

        $zone->rates()->delete(); // Remove old rates
        foreach ($request->rates as $rate) {
            $zone->rates()->create($rate);
        }

        return redirect()->route('admin.shipment')->with('success', 'Shipping zone updated.');
    }

    // Delete zone and rates
    public function destroy($id)
    {
        $zone = ShippingZone::findOrFail($id);
        $zone->rates()->delete();
        $zone->delete();

        return redirect()->route('admin.shipment')->with('success', 'Shipping zone deleted.');
    }
}