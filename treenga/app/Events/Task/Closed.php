<?php

namespace App\Events\Task;

use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Closed implements ShouldBroadcast
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
    }

    public function broadcastWhen(): void
    {
    }

    public function broadcastWith(): void
    {
    }
}
