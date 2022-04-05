<?php

namespace App\Events\Task;

use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;

class Viewed
{
    use Dispatchable;
    use InteractsWithSockets;

    /**
     * Create a new event instance.
     */
    public $task;

    public $team;

    public $me;

    public function __construct(Task $task, Team $team, User $me)
    {
        $this->task = $task;
        $this->team = $team;
        $this->me = $me;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
