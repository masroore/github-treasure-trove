<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['sender'];

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unread($message_id)
    {
        return $this->id !== $message_id && $this->user_id !== auth()->id();
    }

    public function getReadableDateSentAttribute()
    {
        return $this->created_at->format('M d, Y h:i a');
    }
}
