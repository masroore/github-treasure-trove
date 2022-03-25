<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'refrence_no_int',
        'customer_id',
        'store_id',
        'status',
        'add_ons_amount',
        'sub_total',
        'shipping_amount',
        'promo_code_amount',
        'discount_amount',
        'service_charges_amount',
        'total_amount',
        'payment_channel',
        'transaction_status',
        'service_option',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'shipping_latitude',
        'shipping_longitude',
        'promo_code_id',
    ];

    //protected $with=['orderExtra','orderHistories','orderDetails'];
    public function orderDetails()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function orderHistories()
    {
        return $this->hasMany(OrderHistories::class, 'order_id', 'id');
    }

    public function orderExtra()
    {
        return $this->hasOne(OrderPaymentsExtraDetail::class, 'order_id', 'id');
    }
}
