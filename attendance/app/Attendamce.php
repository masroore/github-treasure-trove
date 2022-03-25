<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendamce extends Model
{
    protected $fillable = ['user_id', 'attendance', 'note', 'year', 'month', 'day', 'role', 'date'];
}
