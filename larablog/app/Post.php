<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'category_id', 'post_img', 'details', 'thumbnail',
    ];

    // A post can belongs to a auther
    public function user()
    {
        return $this->belongsTo(User::class); // Select * from posts where user_id = current user id
    }

    // A post has a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A post belongs to many tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // A post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // Get the latest comments
    }
}
