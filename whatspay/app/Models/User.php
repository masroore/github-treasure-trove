<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    // public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'activation_code',
        'activation_key',
        'country_code',
        'wp_num_inc_code',
        'wp_num_exc_code',
        'otp_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_expiry',
        'activation_code',
        'activation_key',
        'forgot_pass',
        'email_reset_hash',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute()
    {
        $default = 'abc.jpg';

        return File::exists(URL::to('/') . Storage::url($this->attributes['image'])) ?: $default;
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'employees', 'user_id', 'store_id');
//            ->select('stores.id as store_id', 'stores.store_name', 'stores.business_url', 'stores.whatsapp_num', 'store_logo', 'status');
//            ->withPivot('store_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'employees', 'user_id', 'role_id')->withPivot('store_id');
    }

    /**
     * get favorite stores.
     */
    public function favoriteStores()
    {
        $store = new Store();

        return $store->select('store_name', 'business_url', 'whatsapp_num', 'store_logo')
            ->join('favorites', 'favorites.favorable_id', '=', 'stores.id')
            ->where([
                'favorable_type' => \get_class($store),
                'favorites.user_id' => Auth::id(),
            ])->get();
    }

    /**
     * get wish list products.
     */
    public function favoriteProducts()
    {
        $products = new Products();

        return $products->select('name')
            ->join('favorites', 'favorites.favorable_id', '=', 'products.id')
            ->where([
                'favorable_type' => \get_class($products),
                'favorites.user_id' => Auth::id(),
                //                'favorites.deleted_at' => null
            ])->get();
    }

    public function notifiable()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
