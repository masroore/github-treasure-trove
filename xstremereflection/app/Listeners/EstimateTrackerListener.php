<?php

namespace Vanguard\Listeners;

use Vanguard\EstimateTracking;

class EstimateTrackerListener
{
    /**
     * Create the event listener.
     */
    public function handle($event): void
    {
        $tracking = new EstimateTracking();
        $tracking->estimateId = $event->estimate->id;
        $tracking->note = $event->message;
        $tracking->save();
    }
}
