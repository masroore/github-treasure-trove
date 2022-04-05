<?php

namespace App\Jobs\Communication;

use App\Notifications\Communicate\Sendmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class Sendmailjob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $students;

    public $compose;

    public $html;

    /**
     * Create a new job instance.
     */
    public function __construct($students, $compose, $html)
    {
        $this->students = $students;
        $this->compose = $compose;
        $this->html = $html;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->students as $student) {
            $email = $student->email;
            Notification::route('mail', $email)
                ->notify(new Sendmail($this->compose, $this->html));
        }
    }
}
