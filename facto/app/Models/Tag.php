<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['cat_id', 'name'];

    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post::class);
    }
}
