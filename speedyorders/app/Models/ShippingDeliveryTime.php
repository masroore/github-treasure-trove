<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingDeliveryTime extends Model
{
    protected $guarded = [''];

    protected $table = 'shipping_delivery_times';

    public function getNameAttribute()
    {
        return ucfirst($this->attributes['name']);
    }
}
