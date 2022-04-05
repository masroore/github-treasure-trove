<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSlugTrait;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Album extends Model implements HasMedia
{
    use Filterable;
    use HasLang;
    use HasMediaTrait;
    use HasSlugTrait;

    public static $slugSourceFields = ['title'];

    protected $guarded = ['id'];

    public $mediaMultipleCollections = ['images'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 263, 164)
            ->performOnCollections('image')
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('image')
            ->nonQueued();
    }

    public function getAllConversions(string $collectionName = 'image')
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

        // if ($filter === 'comment') {
        //     return $query->orderByDesc('comments_count');
        // }

        // if ($filter === 'like') {
        //     return $query->orderByDesc('likes_count');
        // }

        return $query->orderByDesc('created_at');
    }
}
