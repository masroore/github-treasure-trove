<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class HospitalSchedule extends Model
{
    protected $table = 'hospital_schedule';

    public $timestamps;

    public $fillable = [
        'hospital_id',
        'pacient_id',
        'cart_id',
        'start_date',
        'end_date',
        'comment',
    ];

    public $casts = [
        'hospital_id' => 'integer',
        'pacient_id' => 'integer',
        'cart_id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'comment' => 'string',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id', 'id');
    }

    public function pacient()
    {
        return $this->belongsTo(\App\Models\User::class, 'pacient_id', 'id');
    }

    public function getStartDateAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
    }
}
