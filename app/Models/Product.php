<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'weight',
        'status',
        'featured'
    ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function isActive()
    {
        return $this->status === 1;
    }

    public function getPrice()
    {
        $now = Carbon::now();

        $promoProduct = PromoProduct::where(
            'product_id',
            '=',
            $this->id
        )->join('promos', 'promos.id', '=', 'promo_products.promo_id')
            ->where('promos.status', '=', 1)
            ->where('start_at', '<=', $now)   // started
            ->where('end_at', '>=', $now)
            ->orderBy('promo_products.id', 'desc')->limit(1)->first();

        if (!$promoProduct) {
            return $this->price;
        }

        if($promoProduct->discount_type == 'fixed'){
            return $this->price - (float)$promoProduct->discount;
        }

        return $this->price - ($promoProduct->discount / 100) * $this->price;
    }

    public function getOriginalPrice()
    {
        return $this->price;
    }
}
