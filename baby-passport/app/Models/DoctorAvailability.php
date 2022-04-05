<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    protected $table = 'doctor_availability';

    public $timestamps;

    public $fillable = [
        'user_id',
        'day',
        'time_start',
        'time_end',
    ];

    public $casts = [
        'user_id' => 'integer',
        'day' => 'string',
        'time_start' => 'date_format:h:i',
        'time_end' => 'date_format:h:i',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
