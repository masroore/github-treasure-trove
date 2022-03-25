<?php

namespace App\Jobs;

use App\Academicyear;
use App\GraduatingList;
use App\Studentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class level400tograduating implements ShouldQueue
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
        $cademicyear = Academicyear::where('status', 1)->first();
        $academic = $cademicyear->acdemicyear;
        $semester = $cademicyear->semester;

        $checkgradua = GraduatingList::where('level', 'level 400')
            ->where('academicyear', $academic)
            ->get();

        $students = Studentinfo::where('currentlevel', '!=', 'Graduated')->get();

        foreach ($checkgradua as $check) {
            $indexnumber = $check->indexnumber;

            foreach ($students as $row) {
                $userid = $row->id;
                if ($row->indexnumber == $check->indexnumber) {
                    $data = [
                        'currentlevel' => 'Graduating',
                    ];

                    Studentinfo::findorfail($userid)->update($data);
                }
            }
        }
    }
}
