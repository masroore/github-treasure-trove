<?php

namespace App\Events\Team;

use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteUser implements ShouldBroadcast
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
        return [
            'user' => [
                'id' => $this->user->id,
            ],
            'team' => [
                'id' => $this->team->id,
                'slug' => $this->team->slug,
            ],
        ];
    }
}
