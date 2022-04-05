<?php

namespace App\Jobs;

use App\Defer;
use App\Dismssal;
use App\Rasticate;
use App\Studentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class level100to200 implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $students = Studentinfo::where('currentlevel', 'Level 100')->get();

        foreach ($students as $row) {
            $userid = $row->id;
            $indexnumber = $row->indexnumber;

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

            $data = [
                'currentlevel' => 'Level 200',
            ];

            Studentinfo::findorfail($userid)->update($data);
        }
    }
}
