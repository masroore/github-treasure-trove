<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UnitType extends Model
{
    protected $table = 'unit_types';

    protected $fillable = ['name', 'description', 'status', 'created_by', 'updated_by'];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($unit_type): void {
            $unit_type->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($unit_type): void {
            $unit_type->updated_by = Auth::user()->id ?? null;
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'unit_type_id', 'id');
    }
}
