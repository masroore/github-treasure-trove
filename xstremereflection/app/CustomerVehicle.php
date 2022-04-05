<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    public function colorInfo()
    {
        return $this->belongsTo(VehicleColor::class, 'color');
    }

    public function condition()
    {
        return $this->belongsTo(VehicleCondition::class, 'customerCondition');
    }
}
