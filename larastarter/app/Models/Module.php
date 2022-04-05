<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Module extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get modules with permissions.
     *
     * @return mixed
     */
    public static function getWithPermissions()
    {
        return Cache::rememberForever('permissions.getWithPermissions', function () {
            return self::with('permissions')->get();
        });
    }

    /**
     * Flush the cache.
     */
    public static function flushCache(): void
    {
        Cache::forget('permissions.getWithPermissions');
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

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
