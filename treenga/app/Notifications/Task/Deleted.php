<?php

namespace App\Notifications\Task;

use App\Http\Resources\Task\Short as TaskShortResourse;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class Deleted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
        ];
    }

    public function toCategories($notifiable)
    {
        return $this->task->categories;
    }

    public function toTask($notifiable)
    {
        return $this->task;
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'task' => new TaskShortResourse($this->task),
        ]);
    }
}
