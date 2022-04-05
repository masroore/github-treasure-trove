<?php

namespace App\Events\Task;

use App\Http\Resources\Task\Broadcast as TaskBroadcastResourse;
use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created implements ShouldBroadcast
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
        return new PrivateChannel('team.' . $this->team->id);
    }

    public function broadcastWhen()
    {
        return $this->task->isPublic();
    }

    public function broadcastWith()
    {
        return ['task' => new TaskBroadcastResourse($this->task)];
    }
}
