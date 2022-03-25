<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    protected $fillable = ['title', 'startdate', 'enddate', 'border', 'background', 'academicyear', 'semester', 'lectid', 'coursecode', 'lecname'];
}
