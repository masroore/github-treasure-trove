<?php

namespace App\Listeners;

use App\Events\NewTask;
use App\Notifications\NewTask as NewTaskNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class NotifyTaskStudents implements ShouldQueue
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
    public function handle(NewTask $event): void
    {
        $students = $event->task->students->map(function ($s) {
            return $s->user;
        });
        Notification::send($students, new NewTaskNotification($event->teacher->user, route('student.task', ['task' => $event->task->id])));
    }
}
