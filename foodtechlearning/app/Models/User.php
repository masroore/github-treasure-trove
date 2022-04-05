<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getDefaultRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function classes()
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function chatrooms()
    {
        return $this->belongsToMany(Chatroom::class)->withPivot('message_id')->withTimestamps();
    }

    public function getProfilePhotoAttribute(): string
    {
        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getUnreadMessagesAttribute()
    {
        return $this->chatrooms->filter(function ($chatroom) {
            return $chatroom->latest_message?->id !== $chatroom->pivot->message_id && $chatroom->latest_message->user_id !== auth()->id();
        })->count();
    }

    public function roll_calls()
    {
        return $this->hasMany(Rollcall::class);
    }
}
