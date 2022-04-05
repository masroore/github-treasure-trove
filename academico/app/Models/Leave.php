<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Leave.
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $date
 * @property int $leave_type_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\LeaveType $leaveType
 * @property \App\Models\Teacher $teacher
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Leave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Leave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Leave query()
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leave whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Leave extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $guarded = ['id'];

    protected $with = ['leaveType'];

    protected static $logUnguarded = true;

    protected static function boot(): void
    {
        parent::boot();

        // do not save already existing leaves
        static::saving(function (self $leave) {
            if (self::where('teacher_id', $leave->teacher_id)->where('date', $leave->date)->count() > 0) {
                return false;
            }
        });

        // when a leave is, we detach the events from the teacher
        static::saved(function (self $leave): void {
            $events = Event::where('teacher_id', $leave->teacher_id)->whereDate('start', $leave->date)->get();
            foreach ($events as $event) {
                $event->teacher_id = null;
                $event->save();
            }
        });
    }

    public static function upcoming_leaves()
    {
        return self::limit(15)->get()->groupBy('teacher_id'); // todo return first teacher with date span
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
