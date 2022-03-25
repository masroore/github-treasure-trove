<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examcancel extends Model
{
    protected $fillable = ['course_id', 'IA_mark', 'exams_mark', 'total_marks', 'grade', 'grade_point', 'total_gp'];
}
