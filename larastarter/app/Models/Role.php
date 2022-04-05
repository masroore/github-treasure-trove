<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get all roles.
     *
     * @return mixed
     */
    public static function getAllRoles()
    {
        return Cache::rememberForever('roles.all', function () {
            return self::withCount('permissions')->latest('id')->get();
        });
    }

    /**
     * Get roles for select.
     *
     * @return mixed
     */
    public static function getForSelect()
    {
        return Cache::rememberForever('roles.getForSelect', function () {
            return self::select('id', 'name')->get();
        });
    }

    /**
     * Flush the cache.
     */
    public static function flushCache(): void
    {
        Cache::forget('roles.all');
        Cache::forget('roles.getForSelect');
    }

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (): void {
            self::flushCache();
        });

        static::created(function (): void {
            self::flushCache();
        });

        static::deleted(function (): void {
            self::flushCache();
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
