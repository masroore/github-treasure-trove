<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postaldispatch extends Model
{
    protected $fillable = ['to', 'ref', 'address', 'from', 'docdate'];
}
