<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'country_id',
        'address_line_1',
        'address_line_2',
        'city',
        'shipping_zone_id',
        'county',
        'postcode',
    ];

    /**
     * Get the orders that use this address as a billing address.
     */
    public function billingOrders()
    {
        return $this->hasMany(Order::class, 'billing_address_id');
    }

    public function zone(){
        return $this->belongsTo(ShippingZone::class, 'shipping_zone_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    // You might also add a shippingOrders relationship if you have separate shipping addresses
}