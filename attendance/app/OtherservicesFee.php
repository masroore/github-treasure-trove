<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherservicesFee extends Model
{
    protected $fillable = [
        'title',
        'feecode',
        'fee',
    ];
}
