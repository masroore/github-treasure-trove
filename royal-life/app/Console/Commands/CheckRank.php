<?php

namespace App\Console\Commands;

use App\Http\Controllers\RankController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'permite verificar actualizar la informacion de los rangos';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Inicio Cron CheckRango ' . Carbon::now());
        $userRanks = User::all()->where('point_rank', '>', 0);
        $rankController = new RankController();
        foreach ($userRanks as $user) {
            $rankController->checkRank($user->id);
        }
        Log::info('Fin Cron CheckRango ' . Carbon::now());
    }
}
