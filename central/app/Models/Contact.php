<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'ct_contact';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'email',
        'reply',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
