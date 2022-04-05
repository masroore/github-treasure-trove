<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Venue extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'image',
        'imagetype',
        'location',
        'contact',
        'building_type',
        'amenities_detail',
        'other_information',
        'total_room',
        'booking_price',
        'is_available',
        'created_at',
        'updated_at',
        'status',
        'is_deleted',
        'is_featured',
    ];

    public $sortable = [
        'id',
        'name',
        'building_type',
        'total_room',
        'location',
        'booking_price',
        'contact',
        'is_available',
        'booking_per_month',
        'created_at',
        'is_featured',
        'status',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue_images()
    {
        return $this->hasMany(VenueImage::class);
    }

    public function rating_reviews()
    {
        return $this->hasMany(RatingReview::class);
    }

    public function venue_amenities()
    {
        return $this->hasOne(VenueAmenity::class);
    }
}
