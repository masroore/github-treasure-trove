<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }
}
