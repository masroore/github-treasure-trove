<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentfee extends Model
{
    protected $fillable = [
        'indexnumber',
        'fee',
        'feecode',
        'feeamount',
        'paid',
        'owed',
        'semester',
        'type',
    ];
}
