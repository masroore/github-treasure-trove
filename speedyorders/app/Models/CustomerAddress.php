<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_user_id', 'a_first_name', 'a_last_name', 'address_1', 'address_2', 'city', 'postcode', 'country', 'state',
    ];

    public function customerUser()
    {
        return $this->belongsTo('App\Models\CustomerUser')->with('customer');
    }
}
