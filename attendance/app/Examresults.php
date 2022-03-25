<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examresults extends Model
{
    protected $fillable = ['user_id', 'semester', 'year', 'totalgp', 'gpa', 'credithours'];
}
