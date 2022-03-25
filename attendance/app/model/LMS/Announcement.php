<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'message', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
