<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $table = 'doctor_profile';

    public $fillable = [
        'user_id',
        'hospital_id',
        'photo',
        'address',
        'latitude',
        'longitude',
        'rating',
        'appointment_duration',
        'about_me',
    ];

    public $casts = [
        'user_id' => 'integer',
        'hospital_id' => 'integer',
        'address' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'rating' => 'integer',
        'appointment_duration' => 'integer',
        'about_me' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
}
