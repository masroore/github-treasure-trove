<?php

namespace App\Console\Commands\Event;

use App\Models\Event;
use App\Models\Notify;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class EventBegin extends Command
{
    protected $eventToday = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:begin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event begin notification';

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
        $events = Event::with('user', 'users')->where('status', Event::STATUS_WAIT)->orWhere('status', Event::STATUS_ACTIVE)->chunk(100, function ($events): void {
            foreach ($events as $event) {
                if (is_array($event['dates']) || is_object($event['dates'])) {
                    //проверка диапазона времени текущего события
                    $dateFrom = $event['dates']['date']['from'];
                    $dateTo = $event['dates']['date']['to'];
                    //проверка диапазона времени текущего события,
                    foreach ($event['dates']['items'] as $date) {
                        //проверка диапазона времени текущего события,
                        if (Carbon::parse(Carbon::parse($dateFrom)->toDateString() . ' ' . $date['time']['from'])->lte(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->gte(Carbon::now()->setSecond(0))) {
                            $event->update(['status' => Event::STATUS_ACTIVE]);
                        } elseif (Carbon::parse(Carbon::parse($dateTo)->toDateString() . ' ' . $date['time']['to'])->lt(Carbon::now()->setSecond(0))) {
                            $event->update(['status' => Event::STATUS_PASSED]);
                        } else {
                            $event->update(['status' => Event::STATUS_WAIT]);
                        }

                        if (Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->startOfMinute()->subHour()->eq(Carbon::now()->startOfMinute())) {
                            $this->eventToday[] = $event;
                        }
                    }
                }
            }
        });
        if ($this->eventToday) {
            foreach ($this->eventToday as $event) {
                foreach ($event->users()->get() as $user) {
                    Notification::send($user, new \App\Notifications\Event\EventBegin($event));
                    $event->notifies()->create([
                        'user_id' => $user->id,
                        'type' => Notify::TYPE_BEGIN,
                        'text' => trans('notification.event.begin'),
                    ]);
                }
                Notification::send($event->user, new \App\Notifications\Event\EventBegin($event));
                $event->notifies()->create([
                    'user_id' => $event->user_id,
                    'type' => Notify::TYPE_BEGIN,
                    'text' => trans('notification.event.begin'),
                ]);
            }
        }
    }
}
