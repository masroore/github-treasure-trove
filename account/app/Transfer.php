<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from_account',
        'to_account',
        'amount',
        'date',
        'payment_method',
        'reference',
        'description',
        'created_by',
    ];

    public function fromBankAccount()
    {
        return $this->hasOne('App\BankAccount', 'id', 'from_account')->first();
    }

    public function toBankAccount()
    {
        return $this->hasOne('App\BankAccount', 'id', 'to_account')->first();
    }
}
