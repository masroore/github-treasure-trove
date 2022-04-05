<?php

namespace App\Events;

use App\Post;
use App\Topic;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class UserPostedOnTopic
{
    use InteractsWithSockets;
    use SerializesModels;

    public $topic;

    public $post;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Topic $topic, Post $post, User $user)
    {
        $this->topic = $topic;
        $this->post = $post;
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
