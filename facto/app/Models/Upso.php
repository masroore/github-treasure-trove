<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Upso extends Model
{
    public static function boot(): void
    {
        parent::boot();
        self::deleting(function ($upso): void { // before delete() method call this
            $upso->managers()->each(function ($manager): void {
                $manager->delete();
            });

            $upso->premium()->each(function ($manager): void {
                $manager->delete();
            });
        });
    }

    public function premium()
    {
        return $this->hasOne(Premium::class);
    }

    public function upso_type()
    {
        return $this->belongsTo(UpsoType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function all_images()
    {
        return $this->morphMany(AllImage::class, 'all_imagable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
