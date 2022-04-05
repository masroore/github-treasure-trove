<?php

namespace Modules\Payroll\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class PayrollEarnDeduce extends Model
{
    protected $table = 'payroll_earn_deducs';

    protected $guarded = ['id'];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
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
