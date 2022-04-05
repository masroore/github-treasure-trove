<?php

namespace App\Events;

use App\Topic;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class TopicReported
{
    use InteractsWithSockets;
    use SerializesModels;

    public $topic;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Topic $topic, User $user)
    {
        $this->topic = $topic;
        $this->user = $user;
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
