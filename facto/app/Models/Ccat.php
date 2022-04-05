<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccat extends Model
{
    protected $table = 'ccats';

    protected $fillable = ['title', 'key', 'type'];

    public function customers()
    {
        return $this->hasMany(\App\Models\Customer::class);
    }
}
