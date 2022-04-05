<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Booking extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venue_id',
        'user_id',
        'date',
        'booking_name',
        'booking_email',
        'created_at',
        'updated_at',
        'is_deleted',
        'status',
    ];

    public $sortable = [
        'id',
        'date',
        'booking_name',
        'booking_email',
        'created_at',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
