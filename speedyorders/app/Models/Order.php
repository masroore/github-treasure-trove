<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_user_id',
        'invoice_number',
        'invoice_prefix',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'email',
        'postcode',
        'phone',
        'payment_first_name',
        'payment_last_name',
        'payment_company',
        'payment_address_1',
        'payment_address_2',
        'payment_city',
        'payment_region',
        'payment_postcode',
        'payment_country_name',
        'payment_state',
        'payment_method',
        'payment_unique_code',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_region',
        'shipping_postcode',
        'shipping_country_name',
        'shipping_state',
        'shipping_method',
        'shipping_unique_code',
        'shipping_tracking_code',
        'comment',
        'status',
        'commisison',
        'currency_code',
        'currency_value',
        'ip',
        'uuid',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_products')->withPivot('id', 'sku', 'quantity', 'price', 'tax');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function orderedProducts()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function orderHistories()
    {
        return $this->hasMany('App\Models\OrderHistory');
    }

    public function customerTransactions()
    {
        return $this->hasMany('App\Models\CustomerTransaction');
    }

    public function paymentCountry()
    {
        return $this->belongsTo('App\Models\Country', 'payment_country_name');
    }

    public function shippingCountry()
    {
        return $this->belongsTo('App\Models\Country', 'shipping_country_name');
    }

    public function customerUser()
    {
        return $this->belongsTo('App\Models\CustomerUser');
    }
}
