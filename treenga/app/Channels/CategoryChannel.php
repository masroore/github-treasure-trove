<?php

namespace App\Channels;

use App\Category;
use Illuminate\Notifications\Notification;

class CategoryChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     */
    public function send($notifiable, Notification $notification): void
    {
        $categories = $notification->toCategories($notifiable);
        if ($categories instanceof Category) {
            $categories->userNotifications()->attach([$notification->id => ['user_id' => $notifiable->id]]);
        } else {
            foreach ($categories as $category) {
                $category->userNotifications()->attach([$notification->id => ['user_id' => $notifiable->id]]);
            }
        }
    }
}
