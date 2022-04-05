<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * A RemoteEvent represents hours that do not have a specific date/time, but that should be taken into account in the teacher's total for the month or the period.
 *
 * @property int $id
 * @property null|int $teacher_id
 * @property string $name
 * @property int $worked_hours
 * @property null|int $period_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|int $course_id
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property null|\App\Models\Course $course
 * @property null|\App\Models\Period $period
 * @property null|\App\Models\Teacher $teacher
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemoteEvent whereWorkedHours($value)
 * @mixin \Eloquent
 */
class RemoteEvent extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $guarded = ['id'];

    protected static $logUnguarded = true;

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /** we store the time volume in seconds */
    public function getWorkedHoursAttribute($value)
    {
        return $value / 3600;
    }

    /** we store the time volume in seconds */
    public function setWorkedHoursAttribute($value): void
    {
        $this->attributes['worked_hours'] = $value * 3600;
    }
}
