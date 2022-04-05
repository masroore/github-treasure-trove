<?php

namespace App\Jobs;

use App\Mail\AbsenceNotification;
use App\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WatchAttendance implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 5;

    public function __construct(protected Attendance $attendance)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->attendance->attendance_type_id == 4) {
            // if so, send an email
            $student = $this->attendance->student;

            // CC to the teacher and the administration
            $otherRecipients = [];

            if ($this->attendance->event->teacher->email !== null) {
                $otherRecipients[] = ['email' => $this->attendance->event->teacher->email];
            }

            if (config('settings.manager_email') !== null) {
                $otherRecipients[] = ['email' => explode(',', config('settings.manager_email'))];
            }

            // also send to the student's contacts
            foreach ($this->attendance->student->contacts as $contact) {
                $otherRecipients[] = ['email' => $contact->email];
            }

            Mail::to($student->user->email)
                ->locale($student->user->locale)
                ->cc($otherRecipients)
                ->queue(new AbsenceNotification($this->attendance->event, $student->user));
        }
    }
}