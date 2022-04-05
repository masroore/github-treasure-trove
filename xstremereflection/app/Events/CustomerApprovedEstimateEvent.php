<?php

namespace Vanguard\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerApprovedEstimateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $file;

    public $estimate;

    /**
     * Create a new event instance.
     */
    public function __construct($file, $estimate)
    {
        $this->file = $file;
        $this->estimate = $estimate;
        $this->message = 'Estimate ' . $estimate->eid . ' approved by customer and work order created.';
    }
}
