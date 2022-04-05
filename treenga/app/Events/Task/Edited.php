<?php

namespace App\Events\Task;

use App\Http\Resources\Task\BroadcastEdit as TaskBroadcastEditResourse;
use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Edited implements ShouldBroadcast
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

    public $sync;

    public $subscribe;

    public $original;

    public $changesText;

    public function __construct(Task $task, Team $team, User $me, array $sync, array $subscribe, array $original = [], bool $changesText = false)
    {
        $this->task = $task;
        $this->team = $team;
        $this->me = $me;
        $this->sync = $sync;
        $this->subscribe = $subscribe;
        $this->original = $original;
        $this->changesText = $changesText;
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
        return ['task' => new TaskBroadcastEditResourse($this->task)];
    }
}
