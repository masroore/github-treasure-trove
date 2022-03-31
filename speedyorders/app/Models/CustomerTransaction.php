<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    protected $fillable = [
        'customer_user_id', 'description', 'amount', 'order_id', 'type', 'currency', 'status', 'remarks',
    ];

    public function customerUser()
    {
        return $this->belongsTo('App\Models\CustomerUser');
    }
}
