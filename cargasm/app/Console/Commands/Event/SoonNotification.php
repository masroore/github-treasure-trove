<?php

namespace App\Console\Commands\Event;

use App\Models\Event;
use App\Models\Notify;
use App\Notifications\Event\StartingSoon;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SoonNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:soon';

    protected $eventTomorrow = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder of an upcoming event';

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
                    foreach ($event['dates']['items'] as $date) {
                        if ((Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->startOfDay())->eq(Carbon::now()->startOfDay())) {
                            $this->eventTomorrow[] = $event;
                        }
                    }
                }
            }
        });
        if ($this->eventTomorrow) {
            foreach ($this->eventTomorrow as $event) {
                foreach ($event->users()->get() as $user) {
                    Notification::send($user, new \App\Notifications\Event\StartingSoon($event));
                    $event->notifies()->create([
                        'user_id' => $user->id,
                        'type' => Notify::TYPE_BEGIN,
                    ]);
                }
                Notification::send($event->user, new StartingSoon($event));
                $event->notifies()->create([
                    'user_id' => $event->user_id,
                    'type' => Notify::TYPE_BEGIN,
                ]);
            }
        }
    }
}
