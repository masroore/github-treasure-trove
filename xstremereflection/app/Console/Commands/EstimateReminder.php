<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;
use Vanguard\Estimate;

class EstimateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estimate:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $estimate = Estimate::where('status', 1)->get();

        foreach ($estimate as $row) {
            if ($estimate->customer->email) {
            }
        }
    }
}
