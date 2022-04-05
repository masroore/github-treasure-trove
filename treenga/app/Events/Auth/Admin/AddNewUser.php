<?php

namespace App\Events\Auth\Admin;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddNewUser
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $user;

    public $link;

    public $me;

    public function __construct(User $user, string $link, User $me)
    {
        $this->user = $user;
        $this->link = $link;
        $this->me = $me;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return [];
    }
}
