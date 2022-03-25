<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Videoupload extends Model
{
    protected $fillable = ['week', 'title', 'desc', 'url', 'youtubeid', 'academicyear', 'semester', 'user_id', 'course_code', 'fullname'];
}
