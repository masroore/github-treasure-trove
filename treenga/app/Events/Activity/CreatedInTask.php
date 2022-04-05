<?php

namespace App\Events\Activity;

use App\Activity;
use App\Http\Resources\Activity\Short as ActivityShortResourse;
use App\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedInTask implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $task;

    public $activity;

    public function __construct(Task $task, Activity $activity)
    {
        $this->task = $task;
        $this->activity = $activity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.' . $this->task->id);
    }

    public function broadcastWith()
    {
        return ['data' => new ActivityShortResourse($this->activity)];
    }
}
