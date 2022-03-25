<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'appid', 'gender', 'age', 'treatmentfor', 'treatment', 'denote', 'categoty', 'appdate', 'apptime',
    ];

    public function user()
    {
        return $this->belongsto('APP\User');
    }

    public function doctor()
    {
        return $this->belongsto('APP\Doctor');
    }
}
