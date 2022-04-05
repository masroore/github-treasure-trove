<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chatroom extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['latest_message'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('message_id')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderByDesc('id')->latest();
    }

    public function getProfilePhotoAttribute()
    {
        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function latest_message()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getNameAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return $this->users()->where('user_id', '!=', auth()->id())->first()?->name;
    }

    public function scopeLatestMessage($query): void
    {
        $query->orderByDesc(Message::select('created_at')->whereColumn('messages.chatroom_id', 'chatrooms.id')->orderByDesc('created_at')->limit(1));
    }
}
