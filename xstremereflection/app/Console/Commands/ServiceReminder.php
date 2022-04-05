<?php

namespace Vanguard\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Vanguard\Estimate;
use Vanguard\Mail\ServiceTimeReminder;

class ServiceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:reminder';

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
        $estimates = Estimate::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->get();
        $index = 1;
        foreach ($estimates as $row) {
            $eid = $row->companyId . '-' . Carbon::now()->format('y') . '-' . $index;

            $row->eid = $eid;
            $row->save();

            ++$index;
        }
        /*
        $estimates= Estimate::whereDate('created_at', Carbon::today())->where('status', 4 )->get();

        //dd(count($estimate));

        foreach ($estimates as $row)
        {

            if($row->dateofService)
            {
                $start = $row->dateofService;
                $now = Carbon::now();

                $date1 = new DateTime($start);
                $date2 = new DateTime($now);
                $interval = $date1->diff($now);
                $days = $interval->format('%a');
                if($days == $row->maint )
                {
                    $estimate = new Estimate;
                    $estimate->companyId = $row->companyId;
                    $estimate->detailType = $row->detailType;
                    $estimate->customerId = $row->customerId;
                    $estimate->status = 1;
                    $estimate->problem = 'Customer vehicle due for maintenance.';
                    $estimate->save();

                    if($estimate->customer->email)
                    {
                        Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new ServiceTimeReminder($estimate));

                    }else{
                        Mail::to(['jblevins@xtremereflection.app'])->send(new ServiceTimeReminder($estimate));

                    }
                }

            }

        }
    */
        return 0;
    }
}
