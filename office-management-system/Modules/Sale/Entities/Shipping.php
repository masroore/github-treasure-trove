<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $guarded = ['id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
