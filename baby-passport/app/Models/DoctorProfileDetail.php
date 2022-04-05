<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfileDetail extends Model
{
    protected $table = 'doctor_profile_detail';

    public $fillable = [
        'user_id',
        'detail',
        'type',
    ];

    public $casts = [
        'user_id' => 'integer',
        'detail' => 'string',
        'type' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
