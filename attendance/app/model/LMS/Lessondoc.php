<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Lessondoc extends Model
{
    protected $fillable = ['week', 'title', 'doc', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
