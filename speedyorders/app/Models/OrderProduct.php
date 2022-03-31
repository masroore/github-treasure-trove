<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    protected $fillable = [
        'sku', 'quantity', 'price', 'product_id', 'order_id', 'tax', 'shipping_price', 'shipstation_order_id', 'uuid', 'orderuuid', 'shipping_delivery_times_id',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function orderProductOptions()
    {
        return $this->hasMany('App\Models\OrderProductOption');
    }

    public function orderProductGroups()
    {
        return $this->hasMany('App\Models\ProductGroup', 'product_id');
    }
}
