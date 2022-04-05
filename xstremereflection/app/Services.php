<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    public function type()
    {
        return $this->belongsTo(ServiceTypes::class, 'serviceTypeId');
    }
}
