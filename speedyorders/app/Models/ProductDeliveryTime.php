<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDeliveryTime extends Model
{
    protected $table = 'product_deliverytime';

    protected $fillable = ['products_id', 'shipping_delivery_times_id', 'shipping_packages_id', 'shipping_zone_groups_id'];

    public function delivery_time_name()
    {
        return $this->belongsTo('App\Models\ShippingDeliveryTime', 'shipping_delivery_times_id');
    }
}
