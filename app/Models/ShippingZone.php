<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_name',
        'region',
        'country_id'
    ];

    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }

    public  function country(){
        return $this->belongsTo(Country::class);
    }
}
