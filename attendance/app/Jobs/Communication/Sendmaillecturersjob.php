<?php

namespace App\Jobs\Communication;

use App\Notifications\Communicate\Sendmail;
use App\Notifications\Communicate\SendmailnoAttach;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class Sendmaillecturersjob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $lecturer;

    public $compose;

    public $html;

    public $fullpath;

    /**
     * Create a new job instance.
     */
    public function __construct($lecturer, $compose, $html, $fullpath)
    {
        $this->lecturer = $lecturer;
        $this->compose = $compose;
        $this->html = $html;
        $this->fullpath = $fullpath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->lecturer as $lect) {
            $user = User::where('id', $lect->user_id)->first();
            $email = $user->email;

            if ('false' == $this->fullpath) {
                Notification::route('mail', $email)
                    ->notify(new SendmailnoAttach($this->compose, $this->html));
            } else {
                Notification::route('mail', $email)
                    ->notify(new Sendmail($this->compose, $this->html, $this->fullpath));
            }
        }
    }
}
