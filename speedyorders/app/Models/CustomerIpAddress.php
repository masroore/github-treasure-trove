<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerIpAddress extends Model
{
    protected $fillable = [
        'customer_id', 'ip', 'total_accounts',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
