<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'code', 'description', 'status', 'parent_id', 'created_by', 'updated_by', 'level'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function parentCat()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($category): void {
            $category->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($category): void {
            $category->updated_by = Auth::user()->id ?? null;
        });
    }
}
