<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class EstimateService extends Model
{
    public function service()
    {
        return $this->belongsTo(Services::class, 'serviceId');
    }
}
