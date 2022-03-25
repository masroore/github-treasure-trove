<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffdoc extends Model
{
    protected $fillable = ['user_id', 'title', 'doc'];
}
