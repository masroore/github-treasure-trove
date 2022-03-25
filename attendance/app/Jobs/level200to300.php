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

class level200to300 implements ShouldQueue
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
        $students = Studentinfo::where('currentlevel', 'Level 200')->get();

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
                'currentlevel' => 'Level 300',
            ];

            Studentinfo::findorfail($userid)->update($data);
        }
    }
}
