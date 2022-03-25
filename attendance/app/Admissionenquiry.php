<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admissionenquiry extends Model
{
    protected $fillable = ['fullname', 'gender', 'phone', 'email', 'location', 'note'];
}
