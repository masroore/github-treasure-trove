<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paystackmodel extends Model
{
    protected $guarded = [];

    public function paystacklog()
    {
        return $this->hasMany('App\Paystacklog', 'pid');
    }
}
