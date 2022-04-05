<?php

namespace App\Console\Commands;

use App\Cronjob;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DoJob extends Command
{
    protected $signature = 'do:job';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->killprocess();
    }

    public function killprocess(): void
    {
        $job = Cronjob::find(1);
        $status = $job->status;
        $updated_at = $job->updated_at;
        $ddd = Carbon::now()->diffInMinutes($updated_at);
        echo $status . "\n";
        echo $updated_at . "\n";
        echo Carbon::now();
        echo "\n";

        if ($status == 1 && $ddd >= 50) {
            $job->status = 0;
            $job->save();
        }

        // "ps -efw | grep php | grep -v grep | awk '{print $2}' | xargs kill";
    }
}
