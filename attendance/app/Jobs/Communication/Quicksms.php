<?php

namespace App\Jobs\Communication;

use App\Notifications\Quickmail\sendquickmail;
use App\Notifications\Quickmail\sendquickmailwithfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class Quicksms implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $to;

    public $composer;

    public $html;

    public $from;

    public $file;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $composer, $html, $file, $from)
    {
        $this->to = $to;
        $this->composer = $composer;
        $this->html = $html;
        $this->file = $file;
        $this->from = $from;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ('false' == $this->file) {
            Notification::route('mail', $this->from)
                ->notify(new sendquickmail($this->to, $this->composer, $this->html, $this->from));
        } else {
            Notification::route('mail', $this->from)
                ->notify(new sendquickmailwithfile($this->to, $this->composer, $this->html, $this->file, $this->from));
        }
    }
}
