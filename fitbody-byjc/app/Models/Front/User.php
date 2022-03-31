<?php

namespace App\Models\Front;

use App\Models\Back\Orders\Order;
use App\Models\Back\Users\Client;
use App\Models\Back\Users\UserDetail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasRolesAndAbilities;
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
        'role',
        'status',
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    /**
     * @return bool|mixed
     */
    public function clientId()
    {
        $client = $this->hasOne(Client::class, 'user_id')->first();

        return $client ? $client->id : false;
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->where('user_id', auth()->user()->id);
    }
}
