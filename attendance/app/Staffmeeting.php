<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffmeeting extends Model
{
    protected $fillable = ['zoomid', 'user_id', 'uuid', 'title', 'starttime', 'duration', 'join_url', 'start_url', 'created_by_id', 'created_by'];
}
