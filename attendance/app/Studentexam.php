<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentexam extends Model
{
    protected $fillable = ['question_id', 'exam_id', 'user_id'];
}
