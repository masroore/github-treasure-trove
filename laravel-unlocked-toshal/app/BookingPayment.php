<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BookingPayment extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'user_id',
        'user_cookie_id',
        'trans_id',
        'price',
        'commission',
        'payable_amount',
        'created_at',
        'updated_at',
        'trans_status',
    ];
}
