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
        return view('backend.shipment.create');
    }

    // Store a new shipping zone with rates
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'rates' => 'required|array',
            'rates.*.min_weight' => 'required|numeric',
            'rates.*.max_weight' => 'required|numeric',
            'rates.*.rate' => 'required|numeric',
        ]);

        $zone = ShippingZone::create([
            'zone_name' => $request->zone_name,
            'city' => $request->city,
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
        return view('backend.shipment.edit', compact('zone'));
    }

    // Update shipping zone and its rates
    public function update(Request $request, $id)
    {
        $zone = ShippingZone::findOrFail($id);

        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'rates' => 'required|array',
            'rates.*.min_weight' => 'required|numeric',
            'rates.*.max_weight' => 'required|numeric',
            'rates.*.rate' => 'required|numeric',
        ]);

        $zone->update([
            'zone_name' => $request->zone_name,
            'city' => $request->city,
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

// Dummy data for ShippingZone and its rates
$dummyZones = [
    (object) [
        'id' => 1,
        'zone_name' => 'Northern Region',
        'city' => 'Tamale',
        'rates' => [
            (object) [
                'id' => 1,
                'min_weight' => 0,
                'max_weight' => 10,
                'rate' => 5.00,
            ],
            (object) [
                'id' => 2,
                'min_weight' => 10,
                'max_weight' => 20,
                'rate' => 10.00,
            ],
        ],
    ],
    (object) [
        'id' => 2,
        'zone_name' => 'Greater Accra',
        'city' => 'Accra',
        'rates' => [
            (object) [
                'id' => 3,
                'min_weight' => 0,
                'max_weight' => 5,
                'rate' => 3.00,
            ],
            (object) [
                'id' => 4,
                'min_weight' => 5,
                'max_weight' => 15,
                'rate' => 7.00,
            ],
        ],
    ],
];


