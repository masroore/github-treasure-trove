<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsDetail extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'ct_users_notifications_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notify_id',
        'user_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
    ];
}
