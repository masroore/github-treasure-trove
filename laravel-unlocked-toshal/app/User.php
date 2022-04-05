<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use Notifiable;

    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'google_id',
        'facebook_id',
        'email',
        'password',
        'social_type',
        'social_id',
        'created_at',
        'updated_at',
        'is_deleted',
        'status',
    ];

    public $sortable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'social_type',
        'created_at',
        'status',
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

    public $timestamps = true;

    public function user_detail()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function venue()
    {
        return $this->hasMany(Venue::class);
    }

    public function rating_reviews()
    {
        return $this->hasMany(RatingReview::class);
    }
}
