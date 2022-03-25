<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zoomweb extends Model
{
    protected $fillable = ['zoomid', 'user_id', 'uuid', 'title', 'starttime', 'duration', 'level', 'session', 'programme', 'cousers', 'join_url', 'start_url', 'lec_id', 'lec_name', 'academicyear', 'semester'];
}
