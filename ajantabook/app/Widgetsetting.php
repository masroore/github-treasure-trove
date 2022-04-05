<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgetsetting extends Model
{
    public $timestamps = false;

    protected $fillable = [

        'home', 'shop',

    ];
}
