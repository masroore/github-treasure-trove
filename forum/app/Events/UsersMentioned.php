<?php

namespace App\Events;

use App\Post;
use App\Topic;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class UsersMentioned
{
    use InteractsWithSockets;
    use SerializesModels;

    public $users;

    public $topic;

    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct(Collection $users, Topic $topic, Post $post)
    {
        $this->users = $users;
        $this->topic = $topic;
        $this->post = $post;
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
