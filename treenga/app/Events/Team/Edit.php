<?php

namespace App\Events\Team;

use App\Http\Resources\Team\BroadcastEdit as TeamBroadcastEditResourse;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Edit implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $team;

    public $user;

    public function __construct(Team $team, User $user)
    {
        $this->team = $team;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|\Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return [new PrivateChannel('team.' . $this->team->id), new PrivateChannel('user.' . $this->user->id)];
    }

    public function broadcastWith()
    {
        $userId = $this->user->id;
        $team = $this->team->load(['users' => function ($q) use ($userId): void {
            $q->where('user_id', $userId);
        }]);

        return ['team' => new TeamBroadcastEditResourse($team)];
    }
}
