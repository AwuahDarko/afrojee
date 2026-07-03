<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeDeliveryRule extends Model
{
    protected $fillable = [
        'country_id',
        'min_order_amount',
    ];

    protected $casts = [
        'min_order_amount' => 'decimal:2',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
