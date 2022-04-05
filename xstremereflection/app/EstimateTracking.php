<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class EstimateTracking extends Model
{
    public function statusInfo()
    {
        return $this->belongsTo(EstimateStatus::class, 'status');
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimateId');
    }
}
