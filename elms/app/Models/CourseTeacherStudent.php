<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseTeacherStudent extends Pivot
{
    use HasFactory;

    protected $table = 'student_teacher';

    public function students(): void
    {
        $this->belongsToMany(Student::class);
    }

    public function teachers(): void
    {
        $this->belongsToMany(Teacher::class);
    }

    public function courses(): void
    {
        $this->belongsToMany(Course::class);
    }
}
