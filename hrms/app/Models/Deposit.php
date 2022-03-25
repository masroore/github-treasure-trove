<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'date',
        'income_category_id',
        'payer_id',
        'payment_type_id',
        'transaction_id',
        'referal_id',
        'description',
        'created_by',
    ];

    public function account($account)
    {
        return AccountList::where('id', '=', $account)->first();
    }

    public static function payer($payer)
    {
        return Payer::where('id', '=', $payer)->first();
    }

    public function income_category($category)
    {
        return IncomeType::where('id', '=', $category)->first();
    }

    public function payment_type($payment)
    {
        return PaymentType::where('id', '=', $payment)->first();
    }

    public function accounts()
    {
        return $this->hasOne('App\Models\AccountList', 'id', 'account_id');
    }
}
