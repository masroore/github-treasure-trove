<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $with = ['user'];

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsPublish($query)
    {
        return $query->where('status', 1);
    }

    public function getUserName()
    {
        if ($this->name) {
            return $this->name;
        }
        if ($this->user && $this->user->hasRole('admin')) {
            return 'Гость';
        }
        if ($this->user) {
            return $this->user->name;
        }

        return '';
    }
}
