<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function primaryContact()
    {
        return $this->belongsTo(User::class, 'contact');
    }
}
