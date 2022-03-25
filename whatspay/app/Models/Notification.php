<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'body',
        'redirect',
        'sender_id',
        'notifiable_type',
        'notifiable_id',
        'type',
        'status',
        'status',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
