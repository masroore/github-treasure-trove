<?php

namespace App\Models;

use App\Models\Skills\SkillEvaluation;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Enrollment.
 *
 * @property int $id
 * @property int $student_id
 * @property int $responsible_id
 * @property int $course_id
 * @property int $status_id
 * @property null|string $total_price
 * @property null|int $parent_id
 * @property null|int $invoice_id
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|string $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property Enrollment[]|\Illuminate\Database\Eloquent\Collection $childrenEnrollments
 * @property null|int $children_enrollments_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection $comments
 * @property null|int $comments_count
 * @property \App\Models\Course $course
 * @property \App\Models\EnrollmentStatusType $enrollmentStatus
 * @property mixed $absence_count
 * @property mixed $attendance_ratio
 * @property mixed $children
 * @property mixed $children_count
 * @property mixed $date
 * @property mixed $name
 * @property mixed $price
 * @property mixed $price_with_currency
 * @property mixed $product_code
 * @property mixed $result_name
 * @property mixed $status
 * @property mixed $student_age
 * @property mixed $student_birthdate
 * @property mixed $student_email
 * @property mixed $student_name
 * @property mixed $type
 * @property \App\Models\Grade[]|\Illuminate\Database\Eloquent\Collection $grades
 * @property null|int $grades_count
 * @property \App\Models\Invoice[]|\Illuminate\Database\Eloquent\Collection $invoices
 * @property null|int $invoices_count
 * @property null|\App\Models\Result $result
 * @property \Illuminate\Database\Eloquent\Collection|ScheduledPayment[] $scheduledPayments
 * @property null|int $scheduled_payments_count
 * @property \App\Models\Scholarship[]|\Illuminate\Database\Eloquent\Collection $scholarships
 * @property null|int $scholarships_count
 * @property \Illuminate\Database\Eloquent\Collection|SkillEvaluation[] $skill_evaluations
 * @property null|int $skill_evaluations_count
 * @property \App\Models\Student $student
 * @property \App\Models\User $user
 *
 * @method static Builder|Enrollment newModelQuery()
 * @method static Builder|Enrollment newQuery()
 * @method static Builder|Enrollment noresult()
 * @method static Builder|Enrollment parent()
 * @method static Builder|Enrollment pending()
 * @method static Builder|Enrollment period($period)
 * @method static Builder|Enrollment query()
 * @method static Builder|Enrollment real()
 * @method static Builder|Enrollment whereCourseId($value)
 * @method static Builder|Enrollment whereCreatedAt($value)
 * @method static Builder|Enrollment whereDeletedAt($value)
 * @method static Builder|Enrollment whereId($value)
 * @method static Builder|Enrollment whereInvoiceId($value)
 * @method static Builder|Enrollment whereParentId($value)
 * @method static Builder|Enrollment whereResponsibleId($value)
 * @method static Builder|Enrollment whereStatusId($value)
 * @method static Builder|Enrollment whereStudentId($value)
 * @method static Builder|Enrollment whereTotalPrice($value)
 * @method static Builder|Enrollment whereUpdatedAt($value)
 * @method static Builder|Enrollment withoutChildren()
 * @mixin \Eloquent
 */
class Enrollment extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $guarded = ['id'];

    protected $appends = ['type', 'name', 'result_name', 'product_code', 'price', 'price_with_currency'];

    protected $with = ['student', 'course', 'childrenEnrollments'];

    protected static $logUnguarded = true;

    protected $dispatchesEvents = [
        'deleted' => \App\Events\EnrollmentDeleted::class,
        'created' => \App\Events\EnrollmentCreated::class,
        'updating' => \App\Events\EnrollmentUpdating::class,
        'updated' => \App\Events\EnrollmentUpdated::class,
    ];

    /**
     * return all pending enrollments, without the child enrollments.
     */
    public function scopeParent($query)
    {
        return $query
            ->where('parent_id', null)
            ->get();
    }

    public function scopeReal($query)
    {
        return $query
            ->whereDoesntHave('childrenEnrollments')
            ->get();
    }

    public function scopeWithoutChildren($query)
    {
        return $query
            ->where(function ($query): void {
                $query->whereDoesntHave('childrenEnrollments')
                    ->where('parent_id', null);
            })
            ->orWhere(function ($query): void {
                $query->where('parent_id', null);
            })
            ->get();
    }

    /** only pending enrollments */
    public function scopePending($query)
    {
        return $query
            ->where('status_id', 1)
            ->where('parent_id', null)
            ->get();
    }

    public function scopeNoresult($query)
    {
        return $query->doesntHave('result');
    }

    public function scopePeriod(Builder $query, $period)
    {
        return $query->whereHas('course', function ($q) use ($period): void {
            $q->where('period_id', $period);
        });
    }

    /** FUNCTIONS */
    public function changeCourse(Course $newCourse): void
    {
        $this->course_id = $newCourse->id;
        $this->save();
    }

    public function markAsPaid(): void
    {
        $this->status_id = 2;
        $this->save();

        // also mark children as paid
        foreach ($this->childrenEnrollments as $child) {
            $child->status_id = 2;
            $child->save();
        }
    }

    public function isPaid()
    {
        return $this->status_id == 2;
    }

    public function markAsUnpaid(): void
    {
        $this->status_id = 1;
        $this->save();

        $this->invoices()->delete();

        // also mark children as unpaid
        foreach ($this->childrenEnrollments as $child) {
            $child->status_id = 1;
            $child->invoices()->delete();
            $child->save();
        }
    }

    public function addScholarship(Scholarship $scholarship): void
    {
        $this->scholarships()->sync($scholarship);
        $this->markAsPaid();
    }

    public function removeScholarship($scholarship): void
    {
        $this->scholarships()->detach($scholarship);
        $this->markAsUnpaid();
    }

    /** RELATIONS */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class)
            ->with('result_name')
            ->with('comments');
    }

    public function childrenEnrollments()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function enrollmentStatus()
    {
        return $this->belongsTo(EnrollmentStatusType::class, 'status_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function scheduledPayments()
    {
        return $this->hasMany(ScheduledPayment::class);
    }

    public function saveScheduledPayments($payments): void
    {
        $this->scheduledPayments()->delete();
        foreach ($payments as $payment) {
            $this->scheduledPayments()->create([
                'date' => $payment->date,
                'value' => $payment->value,
                'status' => $payment->status,
            ]);
        }
    }

    // Accessors

    public function getResultNameAttribute()
    {
        return $this->result->result_name->name ?? '-';
    }

    public function skill_evaluations()
    {
        return $this->hasMany(SkillEvaluation::class);
    }

    public function getStudentNameAttribute()
    {
        return $this->student->name ?? '';
    }

    public function getNameAttribute()
    {
        return __('Enrollment for') . ' ' . $this->student_name;
    }

    public function getTypeAttribute()
    {
        return 'enrollment';
    }

    /*     public function getStudentIdAttribute()
        {
            return $this->student['id'];
        } */

    public function getStudentAgeAttribute()
    {
        return $this->student->student_age;
    }

    public function getStudentBirthdateAttribute()
    {
        return $this->student->birthdate;
    }

    public function getStudentEmailAttribute()
    {
        return $this->student['email'];
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at, 'UTC')->locale(App::getLocale())->isoFormat('LL');
    }

    public function getChildrenCountAttribute()
    {
        return self::where('parent_id', $this->id)->count();
    }

    public function getChildrenAttribute()
    {
        return self::where('parent_id', $this->id)->with('course')->get();
    }

    public function getStatusAttribute()
    {
        return $this->enrollmentStatus->name;
    }

    public function getProductCodeAttribute()
    {
        return $this->course->rhythm->product_code ?? ' ';
    }

    public function getAttendanceRatioAttribute()
    {
        $courseEventIds = $this->course->events->pluck('id');
        $attendances = $this->student->attendance()->with('event')->get()->whereIn('event_id', $courseEventIds);
        if ($attendances->count() > 0) {
            return round(100 * (($attendances->where('attendance_type_id', 1)->count() + $attendances->where('attendance_type_id', 2)->count() * 0.75) / $attendances->count()));
        }

    }

    public function getAbsenceCountAttribute()
    {
        $courseEventIds = $this->course->events->pluck('id');
        $attendances = $this->student->attendance()->with('event')->get()->whereIn('event_id', $courseEventIds);

        return $attendances->where('attendance_type_id', 3)->count() + $attendances->where('attendance_type_id', 4)->count();
    }

    public function getPriceAttribute()
    {
        if ($this->total_price !== null) {
            return $this->total_price / 100;
        }

        // finally, we default to the course price or 0 (because some screens need a value here, it cannot be null)
        return $this->course->price ?? 0;
    }

    public function getPriceWithCurrencyAttribute()
    {
        if (config('app.currency_position') === 'before') {
            return config('app.currency_symbol') . ' ' . $this->price;
        }

        return $this->price . ' ' . config('app.currency_symbol');
    }

    public function cancel(): void
    {
        // if the enrollment had children, delete them entirely
        if ($this->childrenEnrollments->count() > 0) {
            foreach ($this->childrenEnrollments as $child) {
                $child->delete();
            }
        }

        // delete attendance records related to the enrollment
        $attendances = $this->course->attendance->where('student_id', $this->student->id);
        Attendance::destroy($attendances->map(function ($item, $key) {
            return $item->id;
        }));

        foreach ($this->course->children as $child) {
            $attendances = $child->attendance->where('student_id', $this->student->id);
            Attendance::destroy($attendances->map(function ($item, $key) {
                return $item->id;
            }));
        }

        $this->delete();
    }

    public function setTotalPriceAttribute($value): void
    {
        $this->attributes['total_price'] = $value * 100;
    }
}
