<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamScore extends Model
{
    protected $fillable = ['exam_id', 'user_id', 'score'];
}
