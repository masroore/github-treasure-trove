<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Voucher;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $guarded = ['id'];

    public function showroom()
    {
        return $this->belongsTo(ShowRoom::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($expense): void {
            $expense->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($expense): void {
            $expense->updated_by = Auth::user()->id ?? null;
        });
    }
}
