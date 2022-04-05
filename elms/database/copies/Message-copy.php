<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $dates = ['read_at'];

    protected $appends = ['complement_owner', 'user_role'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeContact($query, User $user): void
    {
        $query->where('sender_id', Auth::id())->where('receiver_id', $user->id)->orWhere('receiver_id', Auth::id())->where('sender_id', $user->id);
    }

    public function getComplementOwnerAttribute()
    {
        if (Auth::id() == $this->sender_id) {
            return User::find($this->receiver_id);
        }

        return User::find($this->sender_id);
    }

    public function getUserRoleAttribute()
    {
        if (Auth::id() == $this->sender_id) {
            return 'sender';
        }

        return 'receiver';
    }

    public function scopeUnread($query): void
    {
        $query->whereNull('read_at');
    }
}
