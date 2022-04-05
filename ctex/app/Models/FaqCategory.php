<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_faq_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
