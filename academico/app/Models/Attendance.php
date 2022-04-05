<?php

namespace App\Models;

use App\Jobs\WatchAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Attendance.
 *
 * @property int $id
 * @property int $student_id
 * @property int $event_id
 * @property int $attendance_type_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\AttendanceType $attendance_type
 * @property \App\Models\Contact[]|\Illuminate\Database\Eloquent\Collection $contacts
 * @property null|int $contacts_count
 * @property \App\Models\Event $event
 * @property \App\Models\Student $student
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAttendanceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attendance extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    protected $with = ['attendance_type'];

    protected static $logUnguarded = true;

    protected static function boot(): void
    {
        parent::boot();

        // when an attendance record is added, we check if this is an absence
        static::saved(function (self $attendance): void {
            if ($attendance->attendance_type_id == 4) { // todo move to configurable settings
                // Log::info('Absence marked for student '.$attendance->student->name);
                // will check the record again and send a notification if it hasn't changed
                WatchAttendance::dispatch($attendance)
                    ->delay(now()); // todo move to configurable settings
            }
        });
    }

    /** RELATIONS */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /** Additional data = contact information associated to the student */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'student_id', 'id');
    }

    /** event = one instance of the course */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendance_type()
    {
        return $this->belongsTo(AttendanceType::class);
    }

    /** METHODS */

    /**
     * get absences count per student
     * this is useful for monitoring the absences.
     */
    public function get_absence_count_per_student(Period $period)
    {
        // return attendance records for period
        $coursesIds = $period->courses->pluck('id');
        $eventsIds = Event::whereIn('course_id', $coursesIds)->pluck('id');

        return self::with('event.course')->with('student')->whereIn('event_id', $eventsIds)->whereIn('attendance_type_id', [3, 4])->get()->groupBy('student_id');
    }

    public function getStudentNameAttribute(): string
    {
        return $this->student->name ?? '';
    }
}
