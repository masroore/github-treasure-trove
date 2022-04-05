<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StaffDocument extends Model
{
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
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
