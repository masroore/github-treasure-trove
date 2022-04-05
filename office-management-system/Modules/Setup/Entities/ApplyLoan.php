<?php

namespace Modules\Setup\Entities;

use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class ApplyLoan extends Model
{
    protected $table = 'apply_loans';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeNonpaid($query)
    {
        return $query->where('approval', 1)->where('paid', 0);
    }

    public function scopeApproval($query)
    {
        return $query->where('approval', 1);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($brand): void {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand): void {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }
}
