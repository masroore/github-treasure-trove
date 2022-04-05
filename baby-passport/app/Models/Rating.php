<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Rating extends Model
{
    protected $table = 'rating';

    public $fillable = [
        'star_number',
        'rating_description',
    ];

    public $casts = [
        'star_number' => 'integer',
        'rating_description' => 'string',
    ];

    public static function rules($id = null)
    {
        $unique = empty($id) ? 'unique:rating,rating_description' : 'unique:rating,rating_description,' . $id . ',id';

        return [
            'star_number' => 'required|integer',
            'rating_description' => 'required|' . $unique,
        ];
    }

    public function hospitals()
    {
        return $this->hasMany(\App\Models\Hospital::class);
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
