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
class Like extends Model
{
    protected $table = 'likeable';

    protected $fillable = ['user_id'];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
