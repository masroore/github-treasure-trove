<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentfine extends Model
{
    protected $fillable = ['user_id', 'fine', 'feecode', 'amount', 'studendid', 'studentfeeid'];
}
