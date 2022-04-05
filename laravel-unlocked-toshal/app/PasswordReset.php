<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'email', 'token',
    ];
}
