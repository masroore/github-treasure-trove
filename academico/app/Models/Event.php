<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prologue\Alerts\Facades\Alert;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Event.
 *
 * @property int $id
 * @property null|int $course_id
 * @property null|int $teacher_id
 * @property null|int $room_id
 * @property string $start
 * @property string $end
 * @property string $name
 * @property null|int $course_time_id
 * @property null|int $exempt_attendance
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\Attendance[]|\Illuminate\Database\Eloquent\Collection $attendance
 * @property null|int $attendance_count
 * @property null|\App\Models\Course $course
 * @property \App\Models\CourseTime $coursetime
 * @property mixed $color
 * @property mixed $end_time
 * @property mixed $event_length
 * @property mixed $formatted_date
 * @property mixed $length
 * @property mixed $period
 * @property mixed $short_date
 * @property mixed $start_time
 * @property mixed $unassigned_teacher
 * @property mixed $volume
 * @property null|\App\Models\Room $room
 * @property null|\App\Models\Teacher $teacher
 *
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereCourseId($value)
 * @method static Builder|Event whereCourseTimeId($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereEnd($value)
 * @method static Builder|Event whereExemptAttendance($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereRoomId($value)
 * @method static Builder|Event whereStart($value)
 * @method static Builder|Event whereTeacherId($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected static function boot(): void
    {
        parent::boot();

        // before adding an event, we check that the teacher is available
        static::saving(function ($event): void {
            $teacher = Teacher::find($event->teacher_id);
            // if the teacher is on leave on the day of the event
            if ($event->teacher_id !== null && $teacher) {
                if ($teacher->leaves->contains('date', Carbon::parse($event->start)->toDateString())) {
                    // detach the teacher from the event
                    $event->teacher_id = null;
                    Alert::warning(__('The selected teacher is not available on this date'))->flash();
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    // protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];

    //protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['length'];

    //protected $with = ['course'];
    protected static $logUnguarded = true;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function coursetime()
    {
        return $this->belongsTo(CourseTime::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class)->withCount('enrollments');
    }

    public function enrollments()
    {
        return $this->course->enrollments();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withTrashed();
    }

    public function room()
    {
        return $this->belongsTo(Room::class)->withTrashed();
    }

    public function getPeriodAttribute()
    {
        return $this->course->period_id;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getLengthAttribute()
    {
        return Carbon::parse($this->end)->diffInSeconds(Carbon::parse($this->start)) / 3600;
    }

    public function getVolumeAttribute()
    {
        return Carbon::parse($this->start)->diffInMinutes(Carbon::parse($this->end)) / 60;
    }

    public function getAttendanceCountAttribute()
    {
        return $this->attendance->count();
    }

    public function getUnassignedTeacherAttribute()
    {
        return $this
            ->whereNull('teacher_id')
            ->where('start', '>', Carbon::now())
            ->where('start', '<', Carbon::parse('+1 month'))
            ->get();
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->start)->toFormattedDateString();
    }

    public function getStartTimeAttribute()
    {
        return Carbon::parse($this->start)->toTimeString();
    }

    public function getEndTimeAttribute()
    {
        return Carbon::parse($this->end)->toTimeString();
    }

    public function getEventLengthAttribute()
    {
        return round(Carbon::parse($this->end)->diffInMinutes(Carbon::parse($this->start)) / 60, 2);
    }

    public function getShortDateAttribute()
    {
        return Carbon::parse($this->start)->day . '/' . Carbon::parse($this->start)->month;
    }

    public function getColorAttribute()
    {
        return $this->course->color ?? ('#' . substr(md5($this->course_id ?? '0'), 0, 6));
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
