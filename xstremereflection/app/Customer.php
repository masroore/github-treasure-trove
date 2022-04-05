<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function vehicles()
    {
        return $this->hasMany(CustomerVehicle::class, 'customerId');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'customerId');
    }
}
