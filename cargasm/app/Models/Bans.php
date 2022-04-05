<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bans extends Model
{
    protected $guarded = ['id'];

    public function banUserData()
    {
        return $this->belongsTo(User::class, 'ban_user_id', 'id');
    }
}
