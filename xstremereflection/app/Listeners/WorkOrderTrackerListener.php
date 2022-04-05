<?php

namespace Vanguard\Listeners;

use Vanguard\Events\CustomerApprovedEstimateEvent;

class WorkOrderTrackerListener
{
    /**
     * Handle the event.
     */
    public function handle(CustomerApprovedEstimateEvent $event): void
    {
    }
}
