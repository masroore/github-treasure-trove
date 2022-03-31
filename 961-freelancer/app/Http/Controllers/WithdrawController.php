<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Models\Wallet;
use App\Models\Withdraw;

class WithdrawController extends Controller
{
    public static function store($response)
    {
        // dd($response);
        $withdraw = Withdraw::create([
            'user_id' => auth()->id(),
            'trans_id' => $response->result->items[0]->payout_item_id,
            'batch_id' => $response->result->batch_header->payout_batch_id,
            'email' => $response->result->items[0]->payout_item->receiver,
            'amount' => $response->result->batch_header->amount->value,
            'currency' => $response->result->batch_header->amount->currency,
        ]);

        if ($withdraw) {
            $wallet = Wallet::where('user_id', auth()->id())->first();
            $newAmt = $wallet->amt - $withdraw->amount;
            $wallet->update(['amt' => $newAmt]);

            TransactionHistory::create([
                'user_id' => auth()->id(),
                'transaction' => 'You Withdraw the amount from your E-Wallet',
                'amount' => $withdraw->amount,
                'type' => 2,
                'status' => 2,
            ]);

            return $withdraw;
        }
    }
}
