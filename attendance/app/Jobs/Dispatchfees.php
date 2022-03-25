<?php

namespace App\Jobs;

use App\Defer;
use App\Dismssal;
use App\Rasticate;
use App\Semesterfee;
use App\Studentfee;
use App\Studentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Dispatchfees implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $students = Studentinfo::where('currentlevel', '!=', 'Graduating')
            ->where('currentlevel', '!=', 'Graduated')->get();

        foreach ($students as $row) {
            $userid = $row->id;
            $indexnumber = $row->indexnumber;
            $currentlevel = $row->currentlevel;
            $session = $row->session;

            //check dimissal || Rasticate | Defer
            $dsmiss = Dismssal::where('studendid', $indexnumber)->first();
            if ($dsmiss) {
                continue;
            }

            $rasticate = Rasticate::where('studentid', $indexnumber)->first();
            if ($rasticate) {
                continue;
            }

            $ras = Defer::where('studentid', $indexnumber)->first();
            if ($ras) {
                continue;
            }

            //Now get all the fees
            $semester = Semesterfee::where('level', $currentlevel)
                ->where('session', $session)->get();

            // dd($semester);

            foreach ($semester as $key => $row) {
                $studentfees = Studentfee::where('indexnumber', $indexnumber)
                    ->where('feecode', $row->feecode)
                    ->where('semester', $row->academicyear)->first();

                //check if fees has already been dispatched

                if ($studentfees) {
                    // do nothing
                } else {
                    //check if fee has already been entered
                    $feesexist = Studentfee::where('indexnumber', $indexnumber)
                        ->where('feecode', $row->feecode)
                        ->first();

                    if ($feesexist) {

                        // if fees exit, update with amount
                        $owed = $feesexist->owed;
                        $feesexist->owed = $row->feeamount + $owed;
                        $feesexist->feeamount = $row->feeamount + $owed;
                        $feesexist->paid = '0';
                        $feesexist->semester = $row->academicyear;
                        $feesexist->save();
                    } else {

                        //this is a new fee
                        $data = [
                        'indexnumber' => $indexnumber,
                        'fee' => $row->fee,
                        'feecode' => $row->feecode,
                        'feeamount' => $row->feeamount,
                        'paid' => 0,
                        'owed' => $row->feeamount,
                        'semester' => $row->academicyear,
                    ];

                        $newfees = new Studentfee($data);
                        $newfees->save();
                    }
                }
            }
        }
    }
}
