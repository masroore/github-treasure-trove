<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $guarded = ['id'];

    const TYPE_FACADE = 'facade';
    const TYPE_INTERIOR = 'interior';

//    protected $filterable = [
//        'type' => 'like'
//    ];

    public function scopeIsFacade($query)
    {
        return $query->where('type', self::TYPE_FACADE);
    }

    public function scopeIsInterior($query)
    {
        return $query->where('type', self::TYPE_INTERIOR);
    }
}
