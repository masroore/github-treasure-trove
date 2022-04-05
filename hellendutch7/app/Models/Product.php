<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $dates = ['publish_at'];

    protected $guarded = [];

    /**
     * Format the product published date.
     */
    public function getPublishedDateAttribute()
    {
        return $this->publish_at->format('M j, Y');
    }

    /**
     * Get the user's discounted Price.
     *
     * @return string
     */
    public function getDiscountedPriceAttribute()
    {
        $discount = $this->price * ($this->discount / 100);

        return $this->price - $discount;
        // return number_format( ($this->price - $discount ),2,'.', ',');
    }

    /**
     * Scope a query to only include users of a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status)->orderBy('publish_at', 'desc');
    }

    public function path()
    {
        return "/product/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Media Definitions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('full')
            ->width(800)
            ->height(800)
            ->sharpen(10);
    }
}
