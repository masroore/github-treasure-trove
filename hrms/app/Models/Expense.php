<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'date',
        'income_category_id',
        'payee_id',
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

    public static function payee($payee)
    {
        return Payees::where('id', '=', $payee)->first();
    }

    public function expense_category($category)
    {
        return ExpenseType::where('id', '=', $category)->first();
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
