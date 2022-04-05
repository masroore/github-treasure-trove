<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Tag extends Model
{
    protected $table = 'tag';

    protected $fillable = [
        'tag',
        'status',
    ];

    protected $casts = [
        'tag' => 'string',
        'status' => 'boolean',
    ];

    public static function rules($id = null)
    {
        $unique = empty($id) ? 'unique:tag' : 'unique:tag,tag,' . $id . ',id';

        return [
            'tag' => 'required|' . $unique,
        ];
    }

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
