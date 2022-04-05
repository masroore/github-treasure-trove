<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'user_id',
    ];

    // A category can belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A category can belongs to a post
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }
}
