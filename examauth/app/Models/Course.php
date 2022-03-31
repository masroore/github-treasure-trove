<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'courses';

    public static $searchable = [
        'course_title',
        'course_code',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'course_title',
        'course_code',
        'course_lecturer_id',
        'department_id',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function course_lecturer()
    {
        return $this->belongsTo(User::class, 'course_lecturer_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
