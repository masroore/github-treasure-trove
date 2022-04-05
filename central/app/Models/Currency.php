<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'ct_currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency',
        'amount_decimals',
        'price_decimals',
        'trade_fee',
        'min_order_amount',
        'max_order_amount',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
