<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramHead extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTeachersAttribute()
    {
        return $this->department ? $this->department->teachers : collect();
    }

    public function getCoursesAttribute()
    {
        $departmentcourses = $this->department ? $this->department->courses : collect();
        $facultycourses = $this->teachers->flatMap(fn ($t) => $t->courses);

        return $departmentcourses->merge($facultycourses);
    }
}
