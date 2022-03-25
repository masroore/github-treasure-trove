<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['fullname', 'phone', 'idcard', 'numofpersons', 'purpose', 'intime', 'outtime', 'note', 'doc'];
}
