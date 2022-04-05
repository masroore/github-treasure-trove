<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalProfile extends Model
{
    protected $table = 'hospital_profile';

    public $fillable = [
        'hospital_id',
        'detail',
        'type',
    ];

    public $casts = [
        'hospital_id' => 'integer',
        'detail' => 'string',
        'type' => 'string',
    ];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
}
