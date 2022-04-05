<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MomHistory extends Model
{
    protected $table = 'mom_history';

    protected $fillable = [
        'father_name',
        'father_phone',
        'father_email',
        'family_from',
        'family-address',
        'married',
        'marriage_paper',
        'usa_family',
        'usa_zip',
        'first_baby',
        'alone_ride',
        'usa_child',
        'familiar_name',
        'familiar_phone',
        'familiar_phone',
    ];

    protected $casts = [
        'father_name' => 'string',
        'father_phone' => 'string',
        'father_email' => 'string',
        'family_from' => 'string',
        'family-address' => 'string',
        'married' => 'boolean',
        'marriage_paper' => 'boolean',
        'usa_family' => 'boolean',
        'usa_zip' => 'boolean',
        'first_baby' => 'boolean',
        'alone_ride' => 'boolean',
        'usa_child' => 'boolean',
        'familiar_name' => 'string',
        'familiar_phone' => 'string',
    ];
}
