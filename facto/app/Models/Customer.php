<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'ccat_id', 'ref_id', 'order', 'name', 'password', 'email', 'homepage', 'title', 'content', 'user_ip', 'visits',
    ];

    public function ccat()
    {
        return $this->belongsTo(\App\Models\Ccat::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
