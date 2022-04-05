<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $likeable_type
 * @property int $likeable_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Timeline extends Model
{
    protected $fillable = ['user_id', 'type', 'description'];

    public const TYPE_SHARE = 'share';
    public const TYPE_ADD = 'add';
    public const TYPE_UPDATE = 'update';

    public function timelines()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
