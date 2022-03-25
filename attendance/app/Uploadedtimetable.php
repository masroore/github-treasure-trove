<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploadedtimetable extends Model
{
    protected $fillable = ['level', 'session', 'type', 'url', 'semester', 'academicyear'];
}
