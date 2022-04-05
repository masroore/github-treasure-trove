<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyFluct extends Model
{
    protected $table = 'ct_daily_fluct';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency',
        'option',
        'value',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
