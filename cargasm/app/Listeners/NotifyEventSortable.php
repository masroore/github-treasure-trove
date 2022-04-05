<?php

namespace App\Listeners;

use App\Events\EventSortable;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEventSortable implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(EventSortable $event): void
    {
        $events = Event::with('user')->chunk(100, function ($events): void {
            foreach ($events as $event) {
                if (is_array($event['dates']) || is_object($event['dates'])) {
                    //проверка диапазона времени текущего события
                    foreach ($event['dates']['items'] as $date) {
                        $firstTime = Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->timestamp;
                        $currentTime = Carbon::now()->timestamp;
                        if ($firstTime > $currentTime) {
                            $event->update(['nearly' => $firstTime - $currentTime]);
//                                $this->eventMax[] = $event->nearly;
                        } else {
                            $event->update(['nearly' => $currentTime - $firstTime + Carbon::now()->timestamp]);
                        }
                    }
                }
            }
        });
    }
}
