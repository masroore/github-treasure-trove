<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSeoTrait;
use App\Models\Traits\HasSlugTrait;
use App\Models\Traits\HasStaticLists;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Variable;

/**
 * @property int $id
 * @property string $title
 * @property string $text
 * @property bool $comment_allowed
 * @property int $status
 * @property string $author_type
 * @property int $author_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Post extends Model implements HasMedia
{
    use Filterable;
    use HasLang;
    use HasMediaTrait;
    use HasSeoTrait;
    use HasSlugTrait;
    use HasStaticLists;
    use Sortable;

    protected $guarded = ['id'];

    public const POST_PUBLISHED = 'published';
    public const POST_MODERATE = 'moderate';
    public const POST_REJECTED = 'rejected';
    public const POST_DRAFT = 'draft';
    public const POST_UNPUBLISHED = 'unpublished';

    public const TYPE_NEWS = 'news';
    public const TYPE_BLOG = 'blog';

    protected $casts = [
        'comment_allowed' => 'boolean',
    ];

    public $sortable = [
        'id',
        'title',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $filterable = [
        'title' => 'like',
        'user_id' => 'equal',
    ];

    protected $searchable = [
        'title', 'text',
    ];

    public static $slugSourceFields = ['title'];

    public $mediaSingleCollections = ['photo'];

    public static function statusList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::POST_PUBLISHED,
                'name' => trans('system.post.statuses.published'),
            ],
            [
                'key' => self::POST_DRAFT,
                'name' => trans('system.post.statuses.draft'),
            ],
            [
                'key' => self::POST_UNPUBLISHED,
                'name' => trans('system.post.statuses.unpublished'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public static function statusesList(): array
    {
        return [
            self::POST_PUBLISHED => 'Опубликовано',
            self::POST_MODERATE => 'На модерации',
            self::POST_REJECTED => 'Отклонено',
            self::POST_DRAFT => 'Черновик',
            self::POST_UNPUBLISHED => 'Неопубликовано',
        ];
    }

    public static function typesList(): array
    {
        return [
            self::TYPE_BLOG => 'Блог',
            self::TYPE_NEWS => 'Новость',
        ];
    }

    public static function authorTypesList(): array
    {
        return [
            User::class => 'Пользователь',
            Service::class => 'СТО',
        ];
    }

    public function getSeo(): array
    {
        if ($tag = $this->metaTag) {
            return [
                'title' => $tag->title,
                'description' => $tag->description,
                'keywords' => $tag->keywords,
                'robots' => $tag->robots,
            ];
        }

        $var = Variable::getArray('seo_masks', null, $this->lang)[$this->post_type] ?? [];

        return [
            'title' => $var['fields']['title'] ?? '',
            'description' => $var['fields']['description'] ?? '',
            'keywords' => $var['fields']['keywords'] ?? '',
            'robots' => 'index',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 360, 200)
            ->performOnCollections('photo')
            ->nonQueued();

        $this->addMediaConversion('big')
            ->format('jpg')
            ->quality(100)
            ->fit('crop', 690, 340)
            ->performOnCollections('photo')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('photo')
            ->nonQueued();
    }

    public function getAllConversions(string $collectionName = 'photo', $isMain = true)
    {
        /** @var Media $media */
        // $media = $isMain
        //     ? $this->getMainMedia($collectionName)
        //     : ($media = $this->getFirstMedia($collectionName));

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

    public function author()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    //жалоба
    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

    //поделится
    public function shares()
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    //добавить в ленту
    public function timelines()
    {
        return $this->morphMany(Timeline::class, 'timelines');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class, 'uuid', 'uuid');
    }

    public function allowComment()
    {
        return $this->comment_allowed;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function scopeAuthor($query, $author, $id)
    {
        if ($author === 'user') {
            return $query->where('author_type', 'App\Models\User')->where('author_id', $id);
        }

        return $query->where('user_id', $id);
    }

    public function scopeSortPost($query, $status)
    {
        if ($status != 'moderate') {
            return $query->orderByDesc('created_at');
        }

        return $query->orderByDesc('updated_at');
    }

    public function checkIssetTranslate($lang)
    {
        return $this->translations->where('language', $lang)->isEmpty() ? false : true;
    }
}
