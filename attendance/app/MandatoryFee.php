<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MandatoryFee extends Model
{
    protected $fillable = [
        'title',
        'feecode',
    ];
}
