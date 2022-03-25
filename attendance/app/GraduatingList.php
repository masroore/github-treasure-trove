<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraduatingList extends Model
{
    protected $fillable = ['user_id', 'programme', 'session', 'academicyear', 'fullname', 'gpa', 'graduatingclas', 'year', 'level', 'indexnumber', 'type'];
}
