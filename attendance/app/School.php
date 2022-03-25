<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name', 'schstart', 'schend', 'name2', 'schstart2', 'schend2',
    ];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }
}
