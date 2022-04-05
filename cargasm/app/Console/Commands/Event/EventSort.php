<?php

namespace App\Console\Commands\Event;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EventSort extends Command
{
//    protected $eventMax = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sort all events';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
                        } else {
                            $event->update(['nearly' => $currentTime - $firstTime + Carbon::now()->timestamp]);
                        }
                    }
                }
            }
        });
    }
}
