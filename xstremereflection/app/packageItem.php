<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class packageItem extends Model
{
    protected $guarded = [];

    public function desc()
    {
        return $this->belongsTo(Services::class, 'serviceId');
    }
}
