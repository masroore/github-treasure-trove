<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VenueImage extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id',
        'name',
        'status',
        'created_at',
        'updated_at',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
