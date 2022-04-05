<?php

namespace App\Jobs\Communication;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Sendsmsindividualjob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $phone;

    public $html;

    public $fullpath;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $html, $fullpath)
    {
        $this->phone = $phone;
        $this->html = $html;
        $this->fullpath = $fullpath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ('false' == $this->fullpath) {
            //without file
        }

        //with file
    }
}
