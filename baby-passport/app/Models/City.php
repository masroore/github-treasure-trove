<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class City extends Model
{
    protected $table = 'city';

    protected $fillable = [
        'city',
        'image',
        'bg_image',
        'copy',
        'description',

    ];

    protected $casts = [
        'city' => 'string',
        'image' => 'string',
        'bg_image' => 'string',
        'copy' => 'string',
        'description' => 'string',
    ];

    public function hospitals()
    {
        return $this->hasMany(\App\Models\Hospital::class);
    }

    public function products()
    {
        return $this->hasManyThrough(\App\Models\HospitalProduct::class, \App\Models\Hospital::class, 'city_id', 'hospital_id');
    }

    public static function rules($id = null)
    {
        $unique = empty($id) ? 'unique:city' : 'unique:city,city,' . $id . ',id';
        $isImageRequired = empty($id) ? 'required|' : '';

        return [
            'city' => 'required|' . $unique,
            'image' => $isImageRequired . 'mimes:jpeg,bmp,png,gif,jpg',
            'bg_image' => $isImageRequired . 'mimes:jpeg,bmp,png,gif,jpg',
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
