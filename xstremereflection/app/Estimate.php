<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public function packages()
    {
        return $this->hasMany(EstimatePackage::class, 'estimateId');
    }

    public function acceptedPackage()
    {
        return $this->belongsTo(EstimatePackage::class, 'approvedPackage');
    }

    public function services()
    {
        return $this->hasMany(EstimateService::class, 'estimateId');
    }

    public function vehicle()
    {
        return $this->hasOne(EstimateVehicle::class, 'estimateId');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function estatus()
    {
        return $this->belongsTo(EstimateStatus::class, 'status');
    }

    public function workorder()
    {
        return $this->hasOne(WorkOrder::class, 'estimateId');
    }

    public function tracking()
    {
        return $this->hasMany(EstimateTracking::class, 'estimateId');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId');
    }
}
