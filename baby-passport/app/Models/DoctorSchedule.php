<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedule';

    public $timestamps;

    public $fillable = [
        'doctor_id',
        'pacient_id',
        'start_date',
        'end_date',
        'comment',
    ];

    public $casts = [
        'doctor_id' => 'integer',
        'pacient_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'comment' => 'string',
    ];

    public function doctor()
    {
        return $this->belongsTo(\App\Models\User::class, 'doctor_id', 'user_id');
    }

    public function pacient()
    {
        return $this->belongsTo(\App\Models\User::class, 'pacient_id', 'user_id');
    }
}
