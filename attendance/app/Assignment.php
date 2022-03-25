<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['lecturer_id', 'lname', 'course_code', 'programme', 'assignment_title', 'assignment_description', 'logo', 'score', 'lecdoc', 'subenddate', 'academicyear', 'semester'];
}
