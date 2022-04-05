<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allstate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'country_id',
    ];

    public function country()
    {
        return $this->belongsTo('App\Allcountry', 'country_id', 'id');
    }

    public function city()
    {
        return $this->hasMany('App\Allcity', 'state_id');
    }
}
