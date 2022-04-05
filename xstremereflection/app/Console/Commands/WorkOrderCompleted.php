<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Vanguard\Mail\CompletedWorkOrder;
use Vanguard\WorkOrder;

class WorkOrderCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workorder:completed';

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
     * @return mixed
     */
    public function handle()
    {
        $workOrder = WorkOrder::with('estimate', 'estimate.customer', 'estimate.customer.company', 'estimate.vehicle', 'estimate.vehicle.vehicleInfo')
                ->where('status', 8)
                ->where('completionEmail', 0)
                ->get();

        foreach ($workOrder as $wo) {
            if ($wo->estimate->customer->email) {
                Mail::to([$wo->estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new CompletedWorkOrder($wo));

                $wo->completionEmail = 1;
                $wo->save();
            }
        }
    }
}
