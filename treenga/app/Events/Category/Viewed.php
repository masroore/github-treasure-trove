<?php

namespace App\Events\Category;

use App\Category;
use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Viewed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $team;

    public $category;

    public function __construct(Team $team, Category $category, User $user)
    {
        $this->category = $category;
        $this->team = $team;
        $this->me = $user;
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
}
