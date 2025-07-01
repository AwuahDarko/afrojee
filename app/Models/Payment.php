<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    protected $fillable = [
        'stripe_session_id',
        'user_id',
        'order_id', 
        'amount',
        'currency',
        'status',
        'payment_method',
        'metadata'
    ];

      protected $casts = [
        'metadata' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
