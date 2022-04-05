<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Date\Date;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'photo', 'type', 'step', 'status', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getCreatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }

    public function getUpdatedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }

    public function address()
    {
        return $this->hasOne(\App\Models\UserAddress::class);
    }

    public function momProfile()
    {
        return $this->hasOne(\App\Models\MomProfile::class);
    }

    public function momHistory()
    {
        return $this->hasOne(\App\Models\MomHistory::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(\App\Models\DoctorProfile::class);
    }

    public function doctorProfileDetail()
    {
        return $this->hasOne(\App\Models\DoctorProfileDetail::class);
    }

    public function pacientAppointment()
    {
        return $this->hasMany(\App\Models\HospitalSchedule::class, 'pacient_id', 'id');
    }

    public function doctorContact()
    {
        return $this->hasMany(\App\Models\DoctorContact::class);
    }

    public function doctorProduct()
    {
        return $this->hasMany(\App\Models\DoctorProduct::class);
    }

    public function doctorAvailability()
    {
        return $this->hasMany(\App\Models\DoctorAvailability::class);
    }

    public function cart()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }

    public function hospitalSchedule()
    {
        return $this->hasMany(\App\Models\HospitalSchedule::class, 'pacient_id', 'id');
    }
}
