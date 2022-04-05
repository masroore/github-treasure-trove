<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_order_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'ordered_at',
        'type1',
        'type2',
        'currency',
        'signal',
        'order_price',
        'order_amount',
        'status',
        'remark',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
