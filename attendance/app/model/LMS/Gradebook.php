<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Gradebook extends Model
{
    protected $fillable = ['attendance', 'quiz', 'exams', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
