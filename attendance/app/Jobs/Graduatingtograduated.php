<?php

namespace App\Jobs;

use App\Studentinfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Graduatingtograduated implements ShouldQueue
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
        $students = Studentinfo::where('currentlevel', 'Graduating')->get();

        foreach ($students as $row) {
            $userid = $row->id;

            $data = [
                'currentlevel' => 'Graduated',
            ];

            Studentinfo::findorfail($userid)->update($data);
        }
    }
}
