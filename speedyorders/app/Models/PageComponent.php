<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class PageComponent extends Model
{
    protected $fillable = ['uuid', 'page_id', 'content', 'status'];

    protected static function boot(): void
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query): void {
            $query->uuid = (string) Str::uuid();
        });
    }
}
