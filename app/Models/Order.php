<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'billing_address_id',
        'shipping_address_id',
        'subtotal',
        'discount_amount',
        'is_first_order',
        'delivery_fee',
        'total_amount',
        'total_weight',
        'status',
        'order_number',
        'payment_status',
        'tracking_number',
        'tracking_link'
        // Add other order specific fields here
    ];

    /**
     * Get the billing address for the order.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the shipping address for the order.
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderProducts(){
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}