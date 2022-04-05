<?php

namespace App\Events;

use App\Models\LoanTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RepaymentUpdated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $loan_transaction;

    /**
     * Create a new event instance.
     */
    public function __construct(LoanTransaction $loan_transaction)
    {
        $this->loan_transaction = $loan_transaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
