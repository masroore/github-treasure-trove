<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examretryresponse extends Model
{
    protected $fillable = ['user_id', 'exam_id', 'question_id', 'option_id', 'answer', 'status'];
}
