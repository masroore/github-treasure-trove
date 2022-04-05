<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminOption extends Model
{
    protected $guarded = ['id'];

    protected static function boot(): void
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query): void {
            $query->uuid = (string) Str::uuid();
        });
    }
}
