<?php

namespace App\model\LMS;

use Illuminate\Database\Eloquent\Model;

class Privatefile extends Model
{
    protected $fillable = ['user_id', 'title', 'file'];
}
