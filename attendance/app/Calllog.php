<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calllog extends Model
{
    protected $fillable = ['fullname', 'phone', 'duration', 'followupdate', 'note', 'type'];
}
