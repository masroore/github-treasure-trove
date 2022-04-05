<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorContact extends Model
{
    protected $table = 'doctor_contact';

    public $timestamps;

    public $fillable = [
        'user_id',
        'contact',
        'type',
    ];

    public $casts = [
        'user_id' => 'integer',
        'contact' => 'string',
        'type' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
