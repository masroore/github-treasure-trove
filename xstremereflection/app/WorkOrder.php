<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimateId', 'id');
    }

    public function services()
    {
        return $this->hasMany(WorkOrderServices::class, 'workOrderId');
    }

    public function wstatus()
    {
        return $this->belongsTo(WorkOrderStatus::class, 'status');
    }
}
