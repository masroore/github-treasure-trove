<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MomProfile extends Model
{
    protected $table = 'mom_profile';

    protected $fillable = [
        'phone',
        'birth_date',
        'job',
        'pregnancy_week',
        'how_found',
        'about_me',
    ];

    protected $casts = [
        'phone' => 'string',
        'birth_date' => 'date',
        'job' => 'string',
        'pregnancy_week' => 'string',
        'how_found' => 'string',
        'about_me' => 'string',
    ];
}
