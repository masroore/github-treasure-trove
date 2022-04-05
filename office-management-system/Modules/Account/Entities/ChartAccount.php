<?php

namespace Modules\Account\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ChartAccount extends Model
{
    protected $fillable = ['name', 'code', 'level', 'type', 'description', 'is_group', 'status', 'parent_id', 'created_by', 'updated_by'];

    //category manage
    public function categories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('categories');
    }

    public function contactable()
    {
        return $this->morphTo();
    }

    public function chart_accounts()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (null !== $parent) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne(AccountCategory::class, 'id', 'parent_id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($modal): void {
            $modal->created_by = Auth::user()->id ?? null;
        });

        static::created(function ($modal): void {
            $modal->code = Auth::user()->id ?? null;
        });

        static::updating(function ($modal): void {
            $modal->updated_by = Auth::user()->id ?? null;
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approve', 1);
    }

    public function scopePaymentAccounts($query)
    {
        return $query->whereIn('configuration_group_id', [1, 2]);
    }

    public function scopeCashPaymentAccounts($query)
    {
        return $query->whereIn('configuration_group_id', [1]);
    }

    public function scopeBankPaymentAccounts($query)
    {
        return $query->whereIn('configuration_group_id', [2]);
    }

    public function scopePayableAccounts($query)
    {
        return $query->where('configuration_group_id', 4);
    }

    public function scopeEquityAccounts($query)
    {
        return $query->where('configuration_group_id', 5);
    }

    public function scopeRecieveAccounts($query)
    {
        return $query->where('configuration_group_id', 3);
    }

    public function scopeExpenceAccounts($query)
    {
        return $query->whereIn('configuration_group_id', [1, 2]);
    }

    public function scopeExpenceAssetAccounts($query)
    {
        return $query->where('type', 1);
    }

    public function scopeIncomeAccounts($query)
    {
        return $query->where('configuration_group_id', 4);
    }

    public function scopeLiabilityAccount($query)
    {
        return $query->where('type', '2');
    }

    public function scopeAssetAccount($query)
    {
        return $query->where('type', '1');
    }

    public function getBalanceAmountAttribute()
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->sum('amount') - $this->transactions->where('type', 'Cr')->sum('amount');
        }

        return $this->transactions->where('type', 'Cr')->sum('amount') - $this->transactions->where('type', 'Dr')->sum('amount');
    }

    public function getDebitAttribute()
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Cr')->sum('amount');
        }

        return $this->transactions->where('type', 'Dr')->sum('amount');
    }

    public function getCreditAttribute()
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->sum('amount');
        }

        return $this->transactions->where('type', 'Cr')->sum('amount');
    }

    public function getBalanceAmountByDate($type)
    {
        if (($this->type == 1 || $this->type == 3)) {
            return $this->transactions()->BalanceAmount($type)->where('type', 'Dr')->sum('amount') - $this->transactions()->BalanceAmount($type)->where('type', 'Cr')->sum('amount');
        }

        return $this->transactions()->BalanceAmount($type)->where('type', 'Cr')->sum('amount') - $this->transactions()->BalanceAmount($type)->where('type', 'Dr')->sum('amount');
    }
}
