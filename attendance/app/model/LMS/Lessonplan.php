<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Lessonplan extends Model
{
    protected $fillable = ['week', 'topic', 'aims', 'obj', 'skills', 'materials', 'questions', 'feedback', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
