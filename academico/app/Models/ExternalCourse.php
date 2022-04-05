<?php

namespace App\Models;

use App\Events\CourseUpdated;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ExternalCourse.
 *
 * @property int $id
 * @property int $campus_id
 * @property null|int $rhythm_id
 * @property null|int $level_id
 * @property int $volume
 * @property string $name
 * @property string $price
 * @property null|string $hourly_price
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property null|int $room_id
 * @property null|int $teacher_id
 * @property null|int $parent_course_id
 * @property null|int $exempt_attendance
 * @property int $period_id
 * @property null|int $opened
 * @property null|int $spots
 * @property null|int $head_count
 * @property null|int $new_students
 * @property null|string $color
 * @property null|int $evaluation_type_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|int $partner_id
 * @property null|string $remote_volume
 * @property null|int $sync_to_lms
 * @property null|int $lms_id
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\Enrollment[]|\Illuminate\Database\Eloquent\Collection $enrollments
 * @property null|int $enrollments_count
 * @property bool $accepts_new_students
 * @property mixed $children
 * @property mixed $children_count
 * @property mixed $course_enrollments_count
 * @property mixed $course_level_name
 * @property mixed $course_period_name
 * @property mixed $course_rhythm_name
 * @property mixed $course_room_name
 * @property mixed $course_teacher_name
 * @property mixed $course_times
 * @property mixed $description
 * @property mixed $formatted_end_date
 * @property mixed $formatted_start_date
 * @property mixed $parent
 * @property mixed $pending_attendance
 * @property mixed $price_with_currency
 * @property mixed $shortname
 * @property mixed $sortable_id
 * @property bool $takes_attendance
 * @property mixed $total_volume
 * @property \App\Models\Enrollment[]|\Illuminate\Database\Eloquent\Collection $real_enrollments
 * @property null|int $real_enrollments_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Course children()
 * @method static \Illuminate\Database\Eloquent\Builder|Course external()
 * @method static \Illuminate\Database\Eloquent\Builder|Course internal()
 * @method static Builder|ExternalCourse newModelQuery()
 * @method static Builder|ExternalCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course parent()
 * @method static Builder|ExternalCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course realcourses()
 * @method static Builder|ExternalCourse whereCampusId($value)
 * @method static Builder|ExternalCourse whereColor($value)
 * @method static Builder|ExternalCourse whereCreatedAt($value)
 * @method static Builder|ExternalCourse whereEndDate($value)
 * @method static Builder|ExternalCourse whereEvaluationTypeId($value)
 * @method static Builder|ExternalCourse whereExemptAttendance($value)
 * @method static Builder|ExternalCourse whereHeadCount($value)
 * @method static Builder|ExternalCourse whereHourlyPrice($value)
 * @method static Builder|ExternalCourse whereId($value)
 * @method static Builder|ExternalCourse whereLevelId($value)
 * @method static Builder|ExternalCourse whereLmsId($value)
 * @method static Builder|ExternalCourse whereName($value)
 * @method static Builder|ExternalCourse whereNewStudents($value)
 * @method static Builder|ExternalCourse whereOpened($value)
 * @method static Builder|ExternalCourse whereParentCourseId($value)
 * @method static Builder|ExternalCourse wherePartnerId($value)
 * @method static Builder|ExternalCourse wherePeriodId($value)
 * @method static Builder|ExternalCourse wherePrice($value)
 * @method static Builder|ExternalCourse whereRemoteVolume($value)
 * @method static Builder|ExternalCourse whereRhythmId($value)
 * @method static Builder|ExternalCourse whereRoomId($value)
 * @method static Builder|ExternalCourse whereSpots($value)
 * @method static Builder|ExternalCourse whereStartDate($value)
 * @method static Builder|ExternalCourse whereSyncToLms($value)
 * @method static Builder|ExternalCourse whereTeacherId($value)
 * @method static Builder|ExternalCourse whereUpdatedAt($value)
 * @method static Builder|ExternalCourse whereVolume($value)
 * @mixin \Eloquent
 */
class ExternalCourse extends Course
{
    use CrudTrait;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('external', function (Builder $builder): void {
            $builder->where('campus_id', 2);
        });
    }

    protected $dispatchesEvents = [
        'updated' => CourseUpdated::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'courses';

    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
