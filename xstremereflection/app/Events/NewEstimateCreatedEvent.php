<?php

namespace Vanguard\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewEstimateCreatedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $estimate;

    /**
     * Create a new event instance.
     */
    public function __construct($estimate)
    {
        $this->estimate = $estimate;
        $this->message = $estimate->eid . ' has been created';
    }
}
