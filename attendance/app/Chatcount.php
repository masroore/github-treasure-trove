<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatcount extends Model
{
    protected $fillable = ['from', 'to', 'count'];
}
