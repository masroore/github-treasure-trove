<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supportingdoc extends Model
{
    protected $fillable = ['name', 'doctype', 'filename'];

    public function osncode()
    {
        return $this->belongsto('App\Osncode');
    }
}
