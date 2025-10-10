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

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function isActive()
    {
        return $this->status === 1;
    }

    public function getPrice()
    {
        $now = Carbon::now();

        // Check for active promotions
        $promoProduct = PromoProduct::where('product_id', '=', $this->id)
            ->join('promos', 'promos.id', '=', 'promo_products.promo_id')
            ->where('promos.status', '=', 1)
            ->where('start_at', '<=', $now)
            ->where('end_at', '>=', $now)
            ->orderBy('promo_products.id', 'desc')
            ->limit(1)
            ->first();

        // If the product has sizes, return the price of the first size (or adjust logic as needed)
        if ($this->sizes()->exists()) {
            $basePrice = $this->sizes()->first()->price;
        } else {
            $basePrice = $this->price;
        }

        if (!$promoProduct) {
            return $basePrice;
        }

        if ($promoProduct->discount_type == 'fixed') {
            return $basePrice - (float) $promoProduct->discount;
        }

        return $basePrice - ($promoProduct->discount / 100) * $basePrice;
    }

    public function getOriginalPrice()
    {
        // If the product has sizes, return the price of the first size (or adjust logic as needed)
        if ($this->sizes()->exists()) {
            return $this->sizes()->first()->price;
        }
        return $this->price;
    }
}