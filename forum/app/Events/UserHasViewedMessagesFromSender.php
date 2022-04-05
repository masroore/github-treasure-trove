<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class UserHasViewedMessagesFromSender
{
    use InteractsWithSockets;
    use SerializesModels;

    public $currentUser;

    public $sender;

    /**
     * Create a new event instance.
     */
    public function __construct(User $currentUser, User $sender)
    {
        $this->currentUser = $currentUser;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
