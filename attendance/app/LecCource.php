<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecCource extends Model
{
    protected $fillable = ['lecturer_id', 'lec_name', 'course', 'code'];
}
