<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class ProductOption extends Model
    {
        protected $hidden = ['created_at', 'updated_at'];

        protected $fillable = [
            'id',
            'required',
            'product_id',
            'option_id',
        ];

        public static function boot(): void
        {
            parent::boot();

            static::deleting(function ($option): void { // before delete() method call this
                $option->optionValues()->delete();
            });
        }

        public function option()
        {
            return $this->belongsTo(Option::class, 'option_id');
        }

        public function product()
        {
            return $this->belongsTo(Product::class, 'product_id');
        }

        public function optionValues()
        {
            return $this->hasMany(ProductOptionValue::class, 'product_option_id');
        }
    }
