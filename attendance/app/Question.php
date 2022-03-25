<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['exam_id', 'question', 'qnumber'];

    public function qestionOptions()
    {
        return $this->hasMany('App\QestionOption');
    }
}
