<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'title',
        'content',
        'status',
    ];

    protected $hidden = [
        'created_at',
    ];
}
