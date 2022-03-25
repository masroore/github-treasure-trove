<?php

namespace App\Jobs\Announcement;

use App\Notifications\Announcement\notifystudent as notifystudents;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class notifystudent implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $students;
    public $title;
    public $message;
    public $from;
    public $fullname;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students, $title, $message, $from, $fullname)
    {
        $this->students = $students;
        $this->title = $title;
        $this->message = $message;
        $this->from = $from;
        $this->fullname = $fullname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->students as $row => $value) {
            $index = $row->indexnumber;
            $student = Studentinfo::where('indexnumber', $index)->first();
            $email = $student->email;

            Notification::route('mail', $email)
                ->notify(new notifystudents($this->from, $this->fremail, $this->subject, $this->compose, $this->studntgroup));
        }
    }
}
