<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'address',
        'mobile',
        'zipcode',
        'profile_picture',
        'imagetype',
        'status',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
