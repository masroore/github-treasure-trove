<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $fillable = ['title', 'for_whom', 'location', 'description', 'from_date', 'to_date', 'image', 'status', 'created_by', 'updated_by'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($model): void {
            $model->created_by = Auth::id() ?? null;
        });

        static::updating(function ($model): void {
            $model->updated_by = Auth::id() ?? null;
        });
    }
}
