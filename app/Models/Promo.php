<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
      protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'discount',
        'discount_type',
    ];


    public function promoProducts(){
       return $this->hasMany(PromoProduct::class, 'promo_id', 'id');
    }
}
