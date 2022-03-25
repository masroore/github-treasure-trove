<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardianinfo extends Model
{
    protected $fillable = [
        'gurdianname', 'relationshp', 'occupation', 'mobile', 'employed',
    ];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }
}
