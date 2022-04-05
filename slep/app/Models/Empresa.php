<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    //n to n relationship
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
