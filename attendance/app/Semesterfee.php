<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semesterfee extends Model
{
    protected $fillable = [
        'level',
        'session',
        'fee',
        'feecode',
        'feeamount',
        'academicyear',
    ];
}
