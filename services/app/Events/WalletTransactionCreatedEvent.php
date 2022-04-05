<?php
/*
 * File name: WalletTransactionCreatedEvent.php
 * Last modified: 2021.08.10 at 18:03:35
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Events;

use App\Models\WalletTransaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WalletTransactionCreatedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(WalletTransaction $walletTransaction)
    {
        if ($walletTransaction->action == 'credit') {
            $walletTransaction->wallet->balance += $walletTransaction->amount;
        } elseif ($walletTransaction->action == 'debit') {
            $walletTransaction->wallet->balance -= $walletTransaction->amount;
        }
        $walletTransaction->wallet->save();
    }
}
