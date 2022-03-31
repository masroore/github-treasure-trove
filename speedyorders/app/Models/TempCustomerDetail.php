<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempCustomerDetail extends Model
{
    protected $table = 'temp_customer_details';

    protected $fillable = [
        'php_session_id',
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

        'shipping_method',
        'shipping_unique_code',
        'shipping_tracking_code',

        'comment',
        'status',
        'currency_code',
        'currency_value',
        'created_at',
    ];
}
