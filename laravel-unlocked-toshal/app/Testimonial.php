<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Testimonial extends Model
{
    use Sortable;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'user_post',
        'image',
        'message',
        'location',
        'status',
        'created_at',
        'updated_at',
    ];

    public $sortable = [
        'id',
        'name',
        'location',
        'user_post',
        'status',
        'created_at',
        'updated_at',
    ];
}
