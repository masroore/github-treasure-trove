<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'tagline',
        'keywords',
        'start_date',
        'end_date',
        'monday',
        'start_time_mon',
        'end_time_mon',
        'tuesday',
        'start_time_tue',
        'end_time_tue',
        'wednesday',
        'start_time_wed',
        'end_time_wed',
        'thursday',
        'start_time_thu',
        'end_time_thu',
        'friday',
        'start_time_fri',
        'end_time_fri',
        'saturday',
        'start_time_sat',
        'end_time_sat',
        'sunday',
        'start_time_sun',
        'end_time_sun',
        'level',
        'level_code',
        'level_number',
        'level_label',
        'duration',
        'video1',
        'video2',
        'video3',
        'standby',
        'dropping',
        'dropping_price',
        'full_price',
        'reduced_price',
        'student_price',
        'unemployed_price',
        'senior_price',
        'thumbnail',
        'focus',
        'type',
        'status',
        'user_id',
        'classroom_id',
        'city_id',
        'organization_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'monday' => 'boolean',
        'tuesday' => 'boolean',
        'wednesday' => 'boolean',
        'thursday' => 'boolean',
        'friday' => 'boolean',
        'saturday' => 'boolean',
        'sunday' => 'boolean',
        'standby' => 'boolean',
        'dropping' => 'boolean',
        'dropping_price' => 'decimal:2',
        'full_price' => 'decimal:2',
        'reduced_price' => 'decimal:2',
        'student_price' => 'decimal:2',
        'unemployed_price' => 'decimal:2',
        'senior_price' => 'decimal:2',
        'user_id' => 'integer',
        'classroom_id' => 'integer',
        'city_id' => 'integer',
        'organization_id' => 'integer',
        'level' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(User::class, 'registrations', 'course_id', 'user_id')->using(Registration::class)->wherePivot('role', 'instructor');
    }

    public function classroom()
    {
        return $this->belongsTo(\App\Models\Classroom::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function styles()
    {
        return $this->belongsToMany(Style::class);
    }

    public function hasStyle($id)
    {
        return in_array($id, $this->styles()->pluck('style_id')->toArray());
    }

    public function scopeIsActive($query)
    {
        return $query->whereStatus('active');
    }

    public function scopeLevel($query, $level)
    {
        if (!empty($level)) {
            return $query->where('level', 'like', '%' . $level . '%');
        }

        return $query;
    }

    public function getTime($time)
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes[$time]);
    }

    public function scopeFocus($query, $focus)
    {
        if (!empty($focus)) {
            return $query->where('focus', $focus);
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeStyle($query, $style)
    {
        // dd($style);
        if (!empty($style)) {
            return $query->whereHas('styles', function (Builder $query_style) use ($style): void {
                $query_style->where('style_id', $style);
            });
        }

        return $query;
    }

    public function scopeOrganization($query, $organization)
    {
        if (!empty($organization)) {
            return $query->where('organization_id', $organization);
        }

        return $query;
    }

    public function scopeClassroom($query, $classroom)
    {
        if (!empty($classroom)) {
            return $query->where('classroom_id', $classroom);
        }

        return $query;
    }

    public function scopeDayOfWeek($query, $day)
    {
        if (!empty($day)) {
            return $query->whereStatus('active')->where($day, '1')->orderBy('start_time_' . $this->getDayAccronym($day), 'asc');
        }

        return $query;
    }

    public function scopeInCity($query, $city)
    {
        if (!empty($city)) {
            return $query->where('city_id', $city);
        }

        return $query;
    }

    public function getDayAccronym($day)
    {
        switch ($day) {
            case 'monday':
                return 'mon';

                break;
            case 'tuesday':
                return 'tue';

                break;
            case 'wednesday':
                return 'wed';

                break;
            case 'thursday':
                return 'thu';

                break;
            case 'friday':
                return 'fri';

                break;
            case 'saturday':
                return 'sat';

                break;
            default:
                return 'sun';

                break;
        }
    }

    public function getNeighbourhoodAttribute()
    {
        return $this->classroom->location->neighborhood ?? '';
    }

    public function getDaysAttribute()
    {
        $days = [];
        if ($this->monday == 1) {
            $days[] = 'monday';
        }
        if ($this->tuesday == 1) {
            $days[] = 'tuesday';
        }
        if ($this->wednesday == 1) {
            $days[] = 'wednesday';
        }
        if ($this->thursday == 1) {
            $days[] = 'thursday';
        }
        if ($this->friday == 1) {
            $days[] = 'friday';
        }
        if ($this->saturday == 1) {
            $days[] = 'saturday';
        }
        if ($this->sunday == 1) {
            $days[] = 'sunday';
        }

        return $days;
    }

    public function scopeShouldExpire($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '<=', Carbon::now());
    }

    public function expire()
    {
        return $this->update(['status' => 'finished']);
    }
}
