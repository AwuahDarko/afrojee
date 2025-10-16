<?php
// app/Models/Product.php

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

    /** NEW: Product Images Relationship */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /** Get primary image */
    public function getPrimaryImage()
    {
        return $this->images()->where('is_primary', 1)->first();
    }

    public function isActive()
    {
        return $this->status === 1;
    }

    public function getPrice()
    {
        $now = Carbon::now();
        $promoProduct = PromoProduct::where('product_id', '=', $this->id)
            ->join('promos', 'promos.id', '=', 'promo_products.promo_id')
            ->where('promos.status', '=', 1)
            ->where('start_at', '<=', $now)
            ->where('end_at', '>=', $now)
            ->orderBy('promo_products.id', 'desc')
            ->limit(1)
            ->first();

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
        if ($this->sizes()->exists()) {
            return $this->sizes()->first()->price;
        }
        return $this->price;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->approved()->orderBy('created_at', 'desc');
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc');
    }

    // 🆕 ADD TO ACCESSORS
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}