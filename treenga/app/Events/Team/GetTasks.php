<?php

namespace App\Events\Team;

use App\Team;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetTasks
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public $team;

    public $user;

    public $point;

    public $onlyTrashed;

    public $id;

    public function __construct(Team $team, User $user, string $point, $onlyTrashed, int $id = 0)
    {
        $this->team = $team;
        $this->user = $user;
        $this->point = $point;
        $this->onlyTrashed = $onlyTrashed;
        $this->id = $id;
    }
}
