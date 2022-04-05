<?php

namespace App\Models;

use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSeoTrait;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Variable;

/**
 * @property int $id
 * @property string $descr
 * @property string $vin
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Car extends Model implements HasMedia
{
    use Filterable;
    use HasMediaTrait;
    use HasSeoTrait;
    use Sortable;

    protected $guarded = ['id'];

    public $mediaMultipleCollections = ['images'];

    protected $casts = [
        'is_sitemap' => 'boolean',
        'is_homemade' => 'boolean',
    ];

    protected $sortable = [
        'id',
        'created_at',
    ];

    protected $filterable = [
        'descr' => 'like',
        'name' => 'like',
        'status' => 'equal',
    ];

    protected $searchable = [
        'name', 'name_en', 'descr', 'vin',
    ];

    public const STATUS_PUBLISHED = 'published';
    public const STATUS_MODERATE = 'moderate';

    public static function statusList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::STATUS_PUBLISHED,
                'name' => trans('system.car.status.published'),
            ],
            [
                'key' => self::STATUS_MODERATE,
                'name' => trans('system.car.status.published'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getStatusStr(): string
    {
        return self::statusList('name', 'key')[$this->status] ?? '';
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 690, 350)
            ->performOnCollections('image')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 165, 113)
            ->performOnCollections('image')
            ->nonQueued();
    }

    public function getAllConversions(string $collectionName = 'image', $isMain = true)
    {
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

        $var = Variable::getArray('seo_masks', null, app()->getLocale())['cars'] ?? [];

        return [
            'title' => $var['fields']['title'] ?? '',
            'description' => $var['fields']['description'] ?? '',
            'keywords' => $var['fields']['keywords'] ?? '',
            'robots' => 'index',
        ];
    }

    public function brand()
    {
        return $this->belongsTo(CarModel::class, 'mark_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id', 'id');
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

    public function clearMediaCollectionMain(string $collectionName = 'default'): self
    {
        $this->getMedia($collectionName)->where('is_main', 1)
            ->each->delete();

        return $this;
    }

//    public function scopeFilter(Builder $builder, QueryFilter $filter)
//    {
//        $filter->apply($builder);
//    }
}
