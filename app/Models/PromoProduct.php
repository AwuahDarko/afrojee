<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoProduct extends Model
{
     protected $fillable = [
        'promo_id',
        'product_id'
    ];

    public function product(){
       return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function promo(){
       return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }
}
