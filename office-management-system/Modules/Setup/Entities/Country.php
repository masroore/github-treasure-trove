<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
