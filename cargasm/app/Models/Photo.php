<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSlugTrait;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

/**
 * @property int $id
 * @property string $title
 * @property bool $comment_allowed
 * @property string $author_type
 * @property int $author_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Photo extends Model implements HasMedia
{
    use Filterable;
    use HasLang;
    use HasMediaTrait;
    use HasSlugTrait;

    public static $slugSourceFields = ['title'];

    protected $guarded = ['id'];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('weight', function (Builder $builder): void {
            $builder->orderBy('weight', 'asc')
                ->orderBy('id', 'asc');
        });
    }

    //поделится
    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    //добавить в ленту
    public function timelines()
    {
        return $this->morphMany(Timeline::class, 'timelines');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function allowComment()
    {
        return $this->comment_allowed;
    }

    public function author()
    {
        return $this->morphTo();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 263, 164)
            ->performOnCollections('images')
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('images')
            ->nonQueued();
    }

    public function getAllConversions(string $collectionName = 'images', $isMain = true)
    {
        /** @var Media $media */
        $media = $this->getFirstMedia($collectionName);

        if ($media) {
            return [
                'avatar' => $media ? $media->getFullUrl('preview') : '',
                'min_avatar' => $media ? $media->getFullUrl('thumb') : '',
                'default' => $media ? $media->getFullUrl() : '',

                'alt' => $media ? $media->custom_properties['alt'] ?? '' : '',
                'title' => $media ? $media->custom_properties['title'] ?? '' : '',
            ];
        }

        return null;
    }

    public function scopeFilter($query, $filter)
    {
        if ($filter === 'date') {
            return $query->orderByDesc('created_at');
        }

        if ($filter === 'comment') {
            return $query->orderByDesc('comments_count');
        }

        if ($filter === 'like') {
            return $query->orderByDesc('likes_count');
        }

        return $query->orderByDesc('created_at');
    }
}
