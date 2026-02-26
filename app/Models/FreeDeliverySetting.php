<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeDeliverySetting extends Model
{
    protected $fillable = [
        'enabled',
        'min_order_amount',
        'country_ids',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'min_order_amount' => 'decimal:2',
        'country_ids' => 'array',
    ];

    /**
     * Get the single free delivery settings row (singleton).
     * Creates default row if none exists.
     */
    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }
        $countryIds = [];
        $spain = \App\Models\Country::whereRaw('LOWER(TRIM(name)) = ?', ['spain'])->first();
        if ($spain) {
            $countryIds = [(int) $spain->id];
        }
        return static::create([
            'enabled' => true,
            'min_order_amount' => 70.00,
            'country_ids' => $countryIds,
        ]);
    }

    /**
     * Check if free delivery is enabled and order qualifies by amount and country.
     */
    public static function orderQualifies(?int $countryId, float $discountedSubtotal): bool
    {
        $s = static::get();
        $countryIds = $s->country_ids ?? [];
        $meetsCountry = $countryId !== null && !empty($countryIds)
            && in_array((int) $countryId, array_map('intval', $countryIds), true);
        $meetsMinimum = $discountedSubtotal >= (float) $s->min_order_amount;
        return $s->enabled && $meetsCountry && $meetsMinimum;
    }
}
