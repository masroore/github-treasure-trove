<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allcity extends Model
{
    public $timestamps = false;

    protected $table = 'allcities';

    protected $fillable = [
        'name', 'state_id', 'pincode',
    ];

    public function state()
    {
        return $this->belongsTo('App\Allstate', 'state_id', 'id');
    }
}
