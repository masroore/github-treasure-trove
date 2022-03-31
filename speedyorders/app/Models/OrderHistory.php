<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id', 'comment', 'status',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
