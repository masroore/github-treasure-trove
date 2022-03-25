<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QestionOption extends Model
{
    protected $fillable = ['question_id', 'option'];

    public function question()
    {
        return $this->hasMany('App\Question', 'exam_id');
    }
}
