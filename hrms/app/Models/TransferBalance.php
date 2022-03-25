<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferBalance extends Model
{
    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'date',
        'amount',
        'payment_type_id',
        'referal_id',
        'description',
        'created_by',
    ];

    public function account($account)
    {
        return AccountList::where('id', '=', $account)->first();
    }

    public function payment_type($payment)
    {
        return PaymentType::where('id', '=', $payment)->first();
    }
}
