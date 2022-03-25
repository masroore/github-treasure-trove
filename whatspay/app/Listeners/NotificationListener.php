<?php

namespace App\Listeners;

class NotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        $data['notifiable_id'] = $event->data['notifiable_id'];
        $data['notifiable_type'] = $event->data['notifiable_type'];
        $data['sender_id'] = $event->data['sender_id'];
        $data['type'] = $event->data['type'];
        $data['redirect'] = $event->data['redirect'];
        $data['title'] = $event->data['title'];
        $data['body'] = $event->data['body'];
        sendNotification($data);
    }
}
