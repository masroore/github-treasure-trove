<?php

namespace App\Events\Team;

use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Delete
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $team;

    public $me;

    public function __construct(Team $team, User $me)
    {
        $this->team = $team;
        $this->me = $me;
    }
}
