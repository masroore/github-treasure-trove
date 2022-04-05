<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyList extends Model
{
    public $timestamps = false;

    protected $table = 'currency_list';

    public function currency()
    {
        return $this->hasMany('App\multiCurrency', 'currency_id');
    }
}
