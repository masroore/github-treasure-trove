<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerImage extends Model
{
    protected $fillable = [];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
