<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id;
 * @property  int $parent_id
 * @property  int $user_id
 * @property string $comment_type
 * @property int $comment_id
 * @property  string $text
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Comment extends Model
{
    protected $table = 'commentable';

    // protected $fillable = ['user_id','text'];
    protected $guarded = ['id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //жалоба
    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function hasParent(): bool
    {
        return (bool) ($this->parent_id);
    }

    public static function getChildTreeArray(Collection $comments, $parentId = null)
    {
        $commentThree = collect([]);

        $thisLevelComment = $comments->where('parent_id', $parentId)->all();

        foreach ($thisLevelComment as $comment) {
            $children = self::getChildTreeArray($comments, $comment->id);
            $comment['children'] = $children;
            $commentThree->push($comment);
        }

        return $commentThree;
    }
}
