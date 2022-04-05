<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    // A tag belongs to many posts
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
