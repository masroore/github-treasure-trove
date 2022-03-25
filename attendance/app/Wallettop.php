<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallettop extends Model
{
    protected $fillable = ['tr_id', 'fullname', 'indexnumber', 'amount'];
}
