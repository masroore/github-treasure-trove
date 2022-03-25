<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dismssal extends Model
{
    protected $fillable = ['user_id', 'studendid', 'reason'];
}
