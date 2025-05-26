<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'category_id',
        'description',
        'image',
        'how_to_use',
        'ingredients',
        'quantity',
        'status',
    ];

     public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function isActive(){
        return $this->status === 1;
    }
}
