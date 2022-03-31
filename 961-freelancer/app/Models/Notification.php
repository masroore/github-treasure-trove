<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
      'from',
      'to',
      'noti_type',
      'message',
      'status',
    ];

    public static function getUnseenNoti()
    {
        return self::where('to', auth()->id())->where('status', 'unread')->count();
    }

    public static function getAllNoti()
    {
        return self::where('to', auth()->id())->orderBy('created_at', 'DESC')->get();
    }
}
