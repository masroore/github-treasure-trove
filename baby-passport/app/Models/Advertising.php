<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Advertising extends Model
{
    protected $table = 'advertising';

    protected $fillable = [
        'title',
        'content',
        'image',
        'url',
        'published_at',
        'expires_at',
        'status',

    ];

    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'image' => 'string',
        'url' => 'string',
        'published_at' => 'string',
        'expires_at' => 'string',
        'status' => 'integer',
    ];

    protected $dates = [
        'published_at',
        'expires_at',
    ];

    public function getPublishedAtAttribute($value)
    {
        $carbon = Carbon::parse($value);

        return Date::instance($carbon);
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

    public static function rules($id, $request)
    {
        $uniqueTitle = empty($id) ? 'unique:advertising,title' : 'unique:advertising,title,' . $id . ',id';

        $rules = [
            'title' => 'required|' . $uniqueTitle,
            'content' => 'required',
            'image' => $id == null ? 'required |' : '' . 'mimes:jpeg,bmp,png,gif,jpg',
            'published_at' => 'required|date_format:Y-m-d',
            'expires_at' => 'nullable|date_format:Y-m-d',
            'url' => 'required',
        ];

        return $rules;
    }
}
