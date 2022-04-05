<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cat extends Model
{
    use SoftDeletes;

    protected $table = 'cats';

    protected $fillable = ['key', 'title', 'type', 'status'];

    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }
}
