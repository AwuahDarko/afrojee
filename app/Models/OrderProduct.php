<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity', 
        'unit_price', 
        'total_price', 
        'unit_weight', 
        'total_weight'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
