<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
