<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\Wallet;

class TransactionController extends Controller
{
    public static function store($request)
    {
        // $data = json_decode(json_encode($request), true);
        // dd($request->result->purchase_units[0]->payments->captures[0]->id);
        $trans = Transaction::create([
            'trans_id' => $request->result->purchase_units[0]->payments->captures[0]->id,
            'user_id' => auth()->id(),
            'token' => $request->result->id,
            'gross_amt' => $request->result->purchase_units[0]->payments->captures[0]->amount->value,
            'net_amt' => $request->result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->net_amount->value,
            'fee_amt' => $request->result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value,
            'payer_id' => $request->result->payer->payer_id,
            'email' => $request->result->payer->email_address,
            'currency_code' => $request->result->purchase_units[0]->payments->captures[0]->amount->currency_code,
            'country_code' => $request->result->payer->address->country_code,
            // 'trans_time' => $request->result->purchase_units[0]->payments->captures[0]->create_time,
        ]);

        if ($trans) {
            User::where('id', auth()->id())->update([
                'paypal_email' => $trans->email,
                'paypal_verified' => 1,
            ]);
            $user = Wallet::where('user_id', $trans->user_id)->first();
            if ('' != $user) {
                $newAmt = $user->amt + $trans->net_amt;
                Wallet::where('user_id', $user->user_id)->update([
                    'amt' => $newAmt,
                ]);
            } else {
                Wallet::create([
                    'user_id' => $trans->user_id,
                    'amt' => $trans->net_amt,
                    'currency_code' => $trans->currency_code,
                ]);
            }
            TransactionHistory::create([
                'user_id' => auth()->id(),
                'transaction' => 'You Deposit the amount in your E-Wallet',
                'amount' => $trans->net_amt,
                'type' => 1,
                'status' => 1,
            ]);

            return $trans;
        }
    }
}
