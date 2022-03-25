<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'address', 'phone',
    ];

    public function user()
    {
        return $this->belongsto('APP\User');
    }
}
