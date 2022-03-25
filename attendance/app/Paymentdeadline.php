<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentdeadline extends Model
{
    protected $fillable = ['date', 'deadline', 'acdemicyear', 'semester'];
}
