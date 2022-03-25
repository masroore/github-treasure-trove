<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetablegroup extends Model
{
    protected $fillable = ['timetable_id', 'group', 'hall', 'lecturer', 'lecturer_id', 'capacity'];
}
