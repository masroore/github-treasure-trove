<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTopic extends Model
{
    protected $table = 'blog_topic';

    public $fillable = [
        'blog_id',
        'title',
        'content',
    ];

    public $casts = [
        'blog_id' => 'integer',
        'title' => 'string',
        'content' => 'string',
    ];

    public function blog()
    {
        return $this->belongsTo(\App\Models\Blog::class);
    }
}
