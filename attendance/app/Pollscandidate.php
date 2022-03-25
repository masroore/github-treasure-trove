<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pollscandidate extends Model
{
    protected $fillable = ['pollstype_id', 'indexnumber', 'fullname', 'position', 'user_id'];
}
