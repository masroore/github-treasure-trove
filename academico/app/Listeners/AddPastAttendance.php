<?php

namespace App\Listeners;

use App\Events\EnrollmentCreated;
use Carbon\Carbon;

class AddPastAttendance
{
    public function handle(EnrollmentCreated $event): void
    {
        $enrollment = $event->enrollment;
        // when creating a new enrollment, also add past attendance
        $events = $enrollment->course->events->where('start', '<', (new Carbon())->toDateString());
        foreach ($events as $event) {
            $event->attendance()->create([
                'student_id' => $enrollment->student_id,
                'attendance_type_id' => 3,
            ]);
        }
    }
}
