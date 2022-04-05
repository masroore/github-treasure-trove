<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class EstimateVehicle extends Model
{
    public function vehicleInfo()
    {
        return $this->belongsTo(CustomerVehicle::class, 'customerVehicleId');
    }
}
