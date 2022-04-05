<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';

    protected $fillable = [
        'blog_id',
        'category_id',
    ];

    protected $casts = [
        'blog_id' => 'integer',
        'category_id' => 'integer',
    ];

    public function blog()
    {
        return $this->belongsTo(\App\Models\Blog::class);
    }
}
