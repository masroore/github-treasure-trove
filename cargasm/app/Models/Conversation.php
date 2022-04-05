<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $guarded = ['id'];

    public function firstData()
    {
        return $this->belongsTo(User::class, 'first', 'id');
    }

    public function secondData()
    {
        return $this->belongsTo(User::class, 'second', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conv_id', 'id');
    }
}
