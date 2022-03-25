<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['exam_id', 'qestion_option_id', 'answer', 'alpha'];
}
