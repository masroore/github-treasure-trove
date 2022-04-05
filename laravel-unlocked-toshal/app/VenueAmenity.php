<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VenueAmenity extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amenity_id',
        'venue_id',
        'created_at',
        'updated_at',
        'status',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
