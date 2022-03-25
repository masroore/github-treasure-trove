<?php

namespace App\Jobs\Communication;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Sendsmslecturersjob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $lecturer;
    public $html;
    public $fullpath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lecturer, $html, $fullpath)
    {
        $this->lecturer = $lecturer;
        $this->html = $html;
        $this->fullpath = $fullpath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->lecturer as $lect) {
            $user = User::where('id', $lect->user_id)->first();
            $email = $user->email;

            if ('false' == $this->fullpath) {

              //without file
            }

            //with file
        }
    }
}
