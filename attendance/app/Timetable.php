<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = ['level', 'sesson', 'programme', 'coursecode', 'course', 'day', 'ftime', 'ttime', 'semester', 'academicyear'];

    public function timegroup()
    {
        return $this->hasMany('App\Timetablegroup');
    }
}
