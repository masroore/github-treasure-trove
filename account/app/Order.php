<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'plan_name',
        'plan_id',
        'price',
        'price_currency',
        'txn_id',
        'payment_status',
        'payment_type',
        'receipt',
        'user_id',
    ];

    public static function total_orders()
    {
        return self::count();
    }

    public static function total_orders_price()
    {
        return self::sum('price');
    }

    public function total_coupon_used()
    {
        return $this->hasOne('App\UserCoupon', 'order', 'order_id');
    }
}
