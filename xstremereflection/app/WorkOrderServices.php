<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class WorkOrderServices extends Model
{
    public function service()
    {
        return $this->belongsTo(Services::class, 'serviceId');
    }
}
