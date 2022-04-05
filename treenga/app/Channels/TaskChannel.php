<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class TaskChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     */
    public function send($notifiable, Notification $notification): void
    {
        $task = $notification->toTask($notifiable);
        $task->userNotifications()->attach([$notification->id => ['user_id' => $notifiable->id]]);
    }
}
