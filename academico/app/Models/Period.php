<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Period.
 *
 * @property int $id
 * @property string $name
 * @property string $start
 * @property string $end
 * @property int $year_id
 * @property null|int $order
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\Course[]|\Illuminate\Database\Eloquent\Collection $courses
 * @property null|int $courses_count
 * @property \App\Models\Enrollment[]|\Illuminate\Database\Eloquent\Collection $enrollments
 * @property null|int $enrollments_count
 * @property \App\Models\Course[]|\Illuminate\Database\Eloquent\Collection $external_courses
 * @property null|int $external_courses_count
 * @property mixed $acquisition_rate
 * @property mixed $courses_with_pending_attendance
 * @property mixed $external_enrollments_count
 * @property mixed $external_sold_hours_count
 * @property mixed $external_students_count
 * @property mixed $external_taught_hours_count
 * @property mixed $internal_enrollments_count
 * @property mixed $new_students_count
 * @property mixed $next_period
 * @property mixed $paid_enrollments_count
 * @property mixed $partnerships_count
 * @property mixed $pending_enrollments_count
 * @property mixed $period_sold_hours_count
 * @property mixed $period_taught_hours_count
 * @property mixed $previous_period
 * @property mixed $students_count
 * @property \App\Models\Course[]|\Illuminate\Database\Eloquent\Collection $internal_courses
 * @property null|int $internal_courses_count
 * @property \App\Models\Enrollment[]|\Illuminate\Database\Eloquent\Collection $real_enrollments
 * @property null|int $real_enrollments_count
 * @property \App\Models\Year $year
 *
 * @method static Builder|Period newModelQuery()
 * @method static Builder|Period newQuery()
 * @method static Builder|Period query()
 * @method static Builder|Period whereEnd($value)
 * @method static Builder|Period whereId($value)
 * @method static Builder|Period whereName($value)
 * @method static Builder|Period whereOrder($value)
 * @method static Builder|Period whereStart($value)
 * @method static Builder|Period whereYearId($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    use CrudTrait;
    use LogsActivity;

    // protected $primaryKey = 'id';
    public $timestamps = false;

    // protected $guarded = ['id'];
    protected $fillable = ['name', 'year_id', 'start', 'end'];

    // protected $hidden = [];
    // protected $dates = [];
    protected static $logUnguarded = true;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder): void {
            $builder->orderBy('year_id')->orderBy('order')->orderBy('id');
        });
    }

    /**
     * Return the current period to be used as a default system-wide.
     * First look in Config DB table; otherwise select current or closest next period.
     */
    public static function get_default_period()
    {
        $configPeriod = Config::where('name', 'current_period');

        if ($configPeriod->exists()) {
            $currentPeriod = $configPeriod->first()->value;

            if (self::where('id', $currentPeriod)->count() > 0) {
                return self::find($currentPeriod);
            }

            return self::where('end', '>=', date('Y-m-d'))->first();
        }

        return self::first();
    }

    /**
     * Return the period to preselect for all enrollment-related methods.
     */
    public static function get_enrollments_period()
    {
        $selected_period = Config::where('name', 'default_enrollment_period')->first()->value;

        if (self::where('id', $selected_period)->count() > 0) {
            return self::find($selected_period);
        }
        // if the current period ends within 15 days, switch to the next one
        $default_period = self::get_default_period();

        // the number of days between the end and today is 2x less than the number of days between start and end
        if (Carbon::parse($default_period->end)->diffInDays() < 0.5 * Carbon::parse($default_period->start)->diffInDays($default_period->end)) {
            return self::where('id', '>', $default_period->id)->orderBy('id')->first();
        }

        return $default_period;
    }

    public function enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Course::class)
            ->with('course');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function internal_courses()
    {
        return $this->hasMany(Course::class)->internal();
    }

    public function external_courses()
    {
        return $this->hasMany(Course::class)->external();
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    /** returns only pending or paid enrollments, without the child enrollments */
    public function real_enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Course::class)
            ->whereIn('status_id', ['1', '2']) // pending or paid
            ->where('parent_id', null);
    }

    /**
     * getPendingEnrollmentsCountAttribute
     * Do not count children enrollments.
     */
    public function getPendingEnrollmentsCountAttribute()
    {
        return $this
            ->enrollments
            ->where('status_id', 1) // pending
            ->where('parent_id', null)
            ->count();
    }

    /**
     * getPaidEnrollmentsCountAttribute
     * Do not count enrollments in children courses.
     */
    public function getPaidEnrollmentsCountAttribute()
    {
        return $this
            ->enrollments
            ->where('status_id', 2) // paid
            ->where('parent_id', null)
            ->count();
    }

    public function getStudentsCountAttribute()
    {
        return DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', 'courses.id')
            ->where('courses.period_id', $this->id)
            ->where('enrollments.deleted_at', null)
            ->where('enrollments.parent_id', null)
            ->whereIn('enrollments.status_id', ['1', '2']) // filter out cancelled enrollments, todo make this configurable.
            ->distinct('student_id')
            ->count('enrollments.student_id');
    }

    public function getInternalEnrollmentsCountAttribute()
    {
        return $this->paid_enrollments_count + $this->pending_enrollments_count;
    }

    public function getExternalEnrollmentsCountAttribute()
    {
        return $this->external_courses->sum('head_count');
    }

    public function getExternalStudentsCountAttribute()
    {
        return $this->external_courses->sum('new_students');
    }

    public function getExternalCoursesCountAttribute()
    {
        return $this->external_courses->count();
    }

    public function getPartnershipsCountAttribute()
    {
        return $this->courses()->pluck('partner_id')->unique()->count();
    }

    public function getPreviousPeriodAttribute()
    {
        $period = self::where('id', '<', $this->id)->orderBy('id', 'desc')->first();

        if (!$period == null) {
            return $period;
        }

        return self::first();
    }

    public function getNextPeriodAttribute()
    {
        return self::where('id', '>', $this->id)->orderBy('id')->first();
    }

    /** Compute the acquisition rate = the part of students from period P-1 who have been kept in period P */
    public function getAcquisitionRateAttribute()
    {
        // get students enrolled in period P-1
        $previous_period_student_ids = $this->previous_period->real_enrollments->pluck('student_id');
        //dump($previous_period_student_ids);

        // and students enrolled in period P
        $current_students_ids = $this->real_enrollments->pluck('student_id');
        //dump($current_students_ids);

        // students both in period p-1 and period p
        $acquired_students = $previous_period_student_ids->intersect($current_students_ids);

        return number_format((100 * $acquired_students->count()) / max($previous_period_student_ids->count(), 1), 1) . '%';
    }

    public function getNewStudentsCountAttribute()
    {
        // get students IDs enrolled in all previous periods
        $previous_period_student_ids = DB::table('enrollments')->join('courses', 'enrollments.course_id', 'courses.id')->where('period_id', '<', $this->id)->pluck('enrollments.student_id');

        // and students enrolled in period P
        $current_students_ids = $this->real_enrollments->unique('student_id');

        // students in period P who have never been enrolled in previous periods
        return $current_students_ids->whereNotIn('student_id', $previous_period_student_ids)->count();
    }

    public function getPeriodTaughtHoursCountAttribute()
    {
        // return the sum of all courses' volume for period
        return $this->internal_courses->where('parent_course_id', null)->sum('total_volume');
    }

    public function getPeriodSoldHoursCountAttribute()
    {
        $total = 0;
        foreach ($this->courses()->internal()->withCount('real_enrollments')->get() as $course) {
            $total += $course->total_volume * $course->real_enrollments_count;
        }

        return $total;
    }

    public function getExternalTaughtHoursCountAttribute()
    {
        // return the sum of all courses' volume for period
        return $this->external_courses->where('parent_course_id', null)->sum('total_volume');
    }

    public function getExternalSoldHoursCountAttribute()
    {
        $total = 0;
        foreach ($this->external_courses as $course) {
            $total += $course->total_volume * $course->head_count;
        }

        return $total;
    }

    /** TODO this method can be furthered optimized and refactored */
    public function getCoursesWithPendingAttendanceAttribute()
    {
        // get all courses for period and preload relations
        $courses = $this->courses()->where(function ($query): void {
            $query->where('exempt_attendance', '!=', true);
            $query->where('exempt_attendance', '!=', 1);
            $query->orWhereNull('exempt_attendance');
        })->whereHas('events')->with('attendance')->whereNotNull('exempt_attendance')->get();
        $coursesWithMissingAttendanceCount = 0;

        // loop through all courses and get the number of events with incomplete attendance
        foreach ($courses as $course) {
            foreach ($course->eventsWithExpectedAttendance as $event) {
                foreach ($course->enrollments as $enrollment) {
                    // if a student has no attendance record for the class (event)
                    $hasNotAttended = $course->attendance->where('student_id', $enrollment->student_id)
                        ->where('event_id', $event->id)
                        ->isEmpty();

                    // count one and break loop
                    if ($hasNotAttended) {
                        ++$coursesWithMissingAttendanceCount;

                        break 2;
                    }
                }
            }
        }

        // sort by number of events with missing attendance
        return $coursesWithMissingAttendanceCount;
    }
}
