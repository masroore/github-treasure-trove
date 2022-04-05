<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Message extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    public function senderData()
    {
        return $this->belongsTo(User::class, 'sender', 'id');
    }

    public function addresseeData()
    {
        return $this->belongsTo(User::class, 'addressee', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conv_id', 'id');
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }
}
