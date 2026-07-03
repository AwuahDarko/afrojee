<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeDeliverySetting extends Model
{
    protected $fillable = [
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Get the single free delivery settings row (singleton) - global on/off only.
     */
    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }
        return static::create(['enabled' => true]);
    }

    /**
     * Check if free delivery is enabled and order qualifies (has a rule for this country with amount met).
     */
    public static function orderQualifies(?int $countryId, float $discountedSubtotal): bool
    {
        if (!static::get()->enabled || $countryId === null) {
            return false;
        }
        $rule = FreeDeliveryRule::where('country_id', $countryId)->first();
        if (!$rule) {
            return false;
        }
        return $discountedSubtotal >= (float) $rule->min_order_amount;
    }
}
