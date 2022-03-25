<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Courseoverview extends Model
{
    protected $fillable = ['overview', 'objectives', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
