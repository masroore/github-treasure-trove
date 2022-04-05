<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalAvailability extends Model
{
    protected $table = 'hospital_availability';

    public $timestamps;

    public $fillable = [
        'hospital_id',
        'day',
        'time_start',
        'time_end',
    ];

    public $casts = [
        'hospital_id' => 'integer',
        'day' => 'string',
        'time_start' => 'date_format:h:i',
        'time_end' => 'date_format:h:i',
    ];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
}
