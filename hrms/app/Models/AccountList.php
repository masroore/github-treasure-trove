<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountList extends Model
{
    protected $fillable = [
        'company_id',
        'account_name',
        'initial_balance',
        'account_number',
        'branch_code',
        'bank_branch',
        'created_by',
    ];

    public static function add_Balance($id, $amount): void
    {
        $accountBalance = self::where('id', '=', $id)->first();
        $accountBalance->initial_balance = $amount + $accountBalance->initial_balance;
        $accountBalance->save();
    }

    public static function remove_Balance($id, $amount): void
    {
        $accountBalance = self::where('id', '=', $id)->first();
        $accountBalance->initial_balance = $accountBalance->initial_balance - $amount;
        $accountBalance->save();
    }

    public static function transfer_Balance($from_account, $to_account, $amount): void
    {
        $fromAccount = self::where('id', '=', $from_account)->first();
        $fromAccount->initial_balance = $fromAccount->initial_balance - $amount;
        $fromAccount->save();
        $toAccount = self::where('id', '=', $to_account)->first();
        $toAccount->initial_balance = $toAccount->initial_balance + $amount;
        $toAccount->save();
    }
}
