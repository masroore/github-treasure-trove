<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradeHistory extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_trade_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'trade_id',
        'settled_at',
        'type',
        'currency',
        'signal',
        'settle_price',
        'settle_amount',
        'fee',
        'fee_currency',
        'status',
        'remark',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
