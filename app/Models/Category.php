<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = [
        'name',
        'status',
        'slug'
    ];


    public function isActive(){
        return $this->status === 1;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
