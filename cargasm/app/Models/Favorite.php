<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Favorite extends Model
{
    protected $table = 'favorites';

    protected $guarded = ['id'];

    protected $fillable = ['user_id'];

    public function favoriteable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function post()
//    {
//        return $this->belongsTo(Post::class);
//    }
//    public function likes()
//    {
//        return $this->morphMany(Like::class, 'likeable');
//    }
//    public function comments()
//    {
//        return $this->morphMany(Comment::class,'commentable');
//    }
}
