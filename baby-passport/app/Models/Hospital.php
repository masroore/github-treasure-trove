<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospital';

    public $fillable = [
        'name',
        'photo',
        'appointment_duration',
        'address',
        'latitude',
        'longitude',
        'rating_id',
        'phone',
        'email',

    ];

    public $casts = [
        'name' => 'string',
        'photo' => 'string',
        'appointment_duration' => 'date_format:h:i',
        'address' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'rating_id' => 'integer',
        'phone' => 'string',
        'email' => 'string',
    ];

    public function rating()
    {
        return $this->belongsTo(\App\Models\Rating::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function hospitalProfile()
    {
        return $this->hasMany(\App\Models\HospitalProfile::class);
    }

    public function hospitalSchedule()
    {
        return $this->hasMany(\App\Models\HospitalSchedule::class, 'hospital_id', 'id');
    }

    public function hospitalContact()
    {
        return $this->hasMany(\App\Models\HospitalContact::class);
    }

    public function hospitalAvailability()
    {
        return $this->hasMany(\App\Models\HospitalAvailability::class);
    }

    public function products()
    {
        return $this->hasMany(\App\Models\HospitalProduct::class);
    }
}
