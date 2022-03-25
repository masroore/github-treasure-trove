<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
//    protected $with='user';
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'body',
        'rating',
        'user_id',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
