<?php

namespace App\Events\Task;

use App\Comment;
use App\Http\Resources\Comment\ListItem as CommentListItemResourse;
use App\Task;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Commented implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $comment;

    public $team;

    public $task;

    public $me;

    public $subscribe;

    public function __construct(Comment $comment, Team $team, Task $task, User $me, array $subscribe)
    {
        $this->comment = $comment;
        $this->team = $team;
        $this->task = $task;
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
        return new PrivateChannel('task.' . $this->task->id);
    }

    public function broadcastWhen()
    {
        return $this->task->isPublic();
    }

    public function broadcastWith()
    {
        return ['comment' => new CommentListItemResourse($this->comment)];
    }
}
