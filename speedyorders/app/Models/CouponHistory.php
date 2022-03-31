<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    protected $fillable = [
        'coupon_id', 'order_id', 'customer_id', 'coupon_code', 'order_amount', 'status',
    ];

    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
