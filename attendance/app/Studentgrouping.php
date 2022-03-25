<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentgrouping extends Model
{
    protected $fillable = ['indexnumber', 'year', 'semester', 'lecname', 'lecid', 'capacity', 'group', 'session', 'coursecode', 'level', 'progcode', 'studentname'];
}
