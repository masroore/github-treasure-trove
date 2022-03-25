<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pollsvote extends Model
{
    protected $fillable = ['pollstype_id', 'user_id', 'pollscandidate_id', 'position'];
}
