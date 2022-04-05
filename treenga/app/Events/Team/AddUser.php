<?php

namespace App\Events\Team;

use App\Http\Resources\User\BroadcastAdd as UserBroadcastAddResourse;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddUser implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $team;

    public $user;

    public $me;

    public function __construct(Team $team, User $user, User $me)
    {
        $this->user = $user;
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
        return [new PrivateChannel('team.' . $this->team->id), new PrivateChannel('user.' . $this->user->id)];
    }

    public function broadcastWith()
    {
        $teamId = $this->team->id;
        $user = $this->user->load(['teams' => function ($q) use ($teamId): void {
            $q->where('team_id', $teamId);
        }]);

        return ['user' => new UserBroadcastAddResourse($user)];
    }
}
