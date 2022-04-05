<?php

namespace App\Jobs\Communication;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Sendsmsstudentsjob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $students;

    public $html;

    public $fullpath;

    /**
     * Create a new job instance.
     */
    public function __construct($students, $html, $fullpath)
    {
        $this->students = $students;
        $this->html = $html;
        $this->fullpath = $fullpath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->students as $student) {
            $email = $student->email;

            if ('false' == $this->fullpath) {

            //without file
            }

            //with file
        }
    }
}
