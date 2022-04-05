<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Variant extends Model
{
    protected $table = 'variants';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'status', 'created_by', 'updated_by'];

    public function values()
    {
        return $this->hasMany(VariantValues::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($variant): void {
            $variant->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($variant): void {
            $variant->updated_by = Auth::user()->id ?? null;
        });
    }
}
