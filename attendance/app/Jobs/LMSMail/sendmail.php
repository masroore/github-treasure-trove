<?php

namespace App\Jobs\LMSMail;

use App\Notifications\LMSMail\sendmail as sendwithoutfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $subject;

    public $compose;

    public $studntgroup;

    public $from;

    public $fremail;

    /**
     * Create a new job instance.
     */
    public function __construct($from, $fremail, $subject, $compose, $studntgroup)
    {
        $this->from = $from;
        $this->fremail = $fremail;
        $this->subject = $subject;
        $this->compose = $compose;
        $this->studntgroup = $studntgroup;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->studntgroup as $row => $value) {
            $index = $row->indexnumber;
            $student = Studentinfo::where('indexnumber', $index)->first();
            $email = $student->email;

            Notification::route('mail', $email)
                ->notify(new sendwithoutfile($this->from, $this->fremail, $this->subject, $this->compose, $this->studntgroup));
        }
    }
}
