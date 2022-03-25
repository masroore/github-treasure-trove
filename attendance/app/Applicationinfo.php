<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationinfo extends Model
{
    protected $guarded = [];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }

    public function personalinfo()
    {
        return $this->hasOne('App\Personalinfo', 'osncode_id');
    }
}
