<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Notification extends Model
{
    protected $table = 'notification';

    protected $fillable = [
        'description',
        'url',
        'user_id',
        'receiver',
        'read',
    ];

    protected $casts = [
        'description' => 'string',
        'url' => 'string',
        'user_id' => 'integer',
        'receiver' => 'string',
        'read' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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
}
