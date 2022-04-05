<?php

namespace App\Jobs\Team;

use App\Repositories\TeamRepository;
use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Delete implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Execute the job.
     */
    public function handle(TeamRepository $teamRepository): void
    {
        $teamRepository->deleteTeamWithAllRelations($this->team);
    }
}
