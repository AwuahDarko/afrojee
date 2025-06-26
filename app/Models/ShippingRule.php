<?php

// app/Models/ShippingRule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $fillable = ['min_weight', 'max_weight', 'price'];
}
