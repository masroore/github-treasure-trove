<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = ['user_id', 'fullname', 'dateofbirth', 'address', 'faculty', 'gender', 'religion', 'qualification', 'number'];

    public function user()
    {
        return $this->belongsto('App\User');
    }
}
