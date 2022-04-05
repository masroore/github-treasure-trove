<?php

namespace Vanguard\Console\Commands;

use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Vanguard\Estimate;
use Vanguard\EstimateTracking;

use Vanguard\Mail\RescheduleReminder;

class JobReschedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:reschedule';

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
        $estimates = Estimate::where('status', 7)->get();

        foreach ($estimates as $estimate) {
            $start = $estimate->rescheduleEmail;
            $now = Carbon::now();

            $date1 = new DateTime($start);
            $date2 = new DateTime($now);
            $interval = $date1->diff($now);
            $days = $interval->format('%a');
            //dd($days);
            //Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new RescheduleReminder($estimate));

            if ($days == 5 || $days == 10) {
                Mail::to([$estimate->customer->email, 'jblevins@xtremereflection.app'])->send(new RescheduleReminder($estimate));
                $tracking = new EstimateTracking();
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'Customer emailed reschedule notification.';
                $tracking->save();
            //dd($days);
            } elseif ($days == 15) {
                $estimate->status = 6;
                $estimate->save();

                $tracking = new EstimateTracking();
                $tracking->estimateId = $estimate->id;
                $tracking->note = 'Customer failed to answer reschedule request within 15 days estimate canceled.';
                $tracking->save();
            }
        }
    }
}
