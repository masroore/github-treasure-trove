<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programmecourse extends Model
{
    protected $fillable = ['programme', 'progcode', 'semester', 'coursetitle', 'coursecode', 'credithours', 'level'];
}
