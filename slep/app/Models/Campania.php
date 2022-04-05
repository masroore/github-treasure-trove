<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{
    use HasFactory;

    //n to n relationship
    public function busquedas()
    {
        return $this->belongsToMany('App\Models\Busqueda');
    }
}
