<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimateId');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoiceId');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId');
    }
}
