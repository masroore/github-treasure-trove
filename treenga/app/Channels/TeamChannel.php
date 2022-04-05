<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class TeamChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     */
    public function send($notifiable, Notification $notification): void
    {
        $team = $notification->toTeam($notifiable);
        $team->userNotifications()->attach([$notification->id => ['user_id' => $notifiable->id]]);
    }
}
