<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    public const TYPE_MESSAGE = 'message';
    public const TYPE_LIKE = 'like';
    public const TYPE_SHARE = 'share';
    public const TYPE_CHANGE = 'change';
    public const TYPE_MODERATE = 'moderate';
    public const TYPE_PUBLISHED = 'published';
    public const TYPE_COMMENT = 'comment';
    public const TYPE_COMMENT_RESPONSE = 'comment_response';
    public const TYPE_SUBSCRIBER = 'subscriber';
    public const TYPE_STATUS = 'status';
    public const TYPE_ATTEND = 'attend';
    public const TYPE_BEGIN = 'begin';

    protected $guarded = ['id'];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
