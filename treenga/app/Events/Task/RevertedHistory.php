<?php

namespace App\Events\Task;

use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RevertedHistory
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $task;

    public $team;

    public $me;

    public $subscribe;

    public function __construct(Task $task, Team $team, User $me, array $subscribe)
    {
        $this->task = $task;
        $this->team = $team;
        $this->me = $me;
        $this->subscribe = $subscribe;
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
