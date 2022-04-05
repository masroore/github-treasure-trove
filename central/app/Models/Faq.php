<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'ct_faq';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'question',
        'answer',
        'category',
        'rank',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
