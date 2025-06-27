<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
      protected $fillable = [
        'name',
        'status',
    ];


    public function isActive(){
        return $this->status === 1;
    }

    public function shippingZones(){
        return $this->hasMany(ShippingZone::class, 'country_id');
    }
}
