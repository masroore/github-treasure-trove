<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class UserRoleModified
{
    use InteractsWithSockets;
    use SerializesModels;

    public $old_role;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(string $old_role, User $user)
    {
        $this->old_role = $old_role;
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
