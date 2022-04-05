<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user can have many posts
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    // A user can have many comments
    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    // Define user and role relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Define a user permissions
    public function permissions()
    {
        return $this->role->permissions->pluck('slug')->unique();
    }

    public function isAdmin()
    {
        return $this->role->name === 'Admin';
    }

    public function isSuperAdmin()
    {
        return $this->role->name === 'SuperAdmin';
    }
}
