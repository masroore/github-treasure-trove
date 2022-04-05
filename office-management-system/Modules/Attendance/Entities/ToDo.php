<?php

namespace Modules\Attendance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ToDo extends Model
{
    protected $fillable = ['status', 'title'];

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
