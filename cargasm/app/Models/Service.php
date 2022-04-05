<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSeoTrait;
use App\Models\Traits\HasSlugTrait;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use stdClass;
use Variable;

/**
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $working
 * @property string $descr
 * @property string $service
 * @property string $video
 * @property string $social
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class Service extends Model implements HasMedia
{
    use Filterable;
    use HasLang;
    use HasMediaTrait;
    use HasSeoTrait;
    use HasSlugTrait;
    use Sortable;

    protected $guarded = ['id'];

    public const SERVICE_PUBLISHED = 'published';
    public const SERVICE_MODERATE = 'moderate';
    public const SERVICE_REJECTED = 'rejected';
    public const SERVICE_DRAFT = 'draft';

    public const TYPE_PARTNER = 'partner';
    public const TYPE_SERVICE = 'service';

    protected $casts = [
        'working' => 'array',
        'service' => 'array',
        'video' => 'array',
        'social' => 'array',
        'is_active' => 'boolean',
        'is_sitemap' => 'boolean',
    ];

    public $sortable = [
        'id',
        'name',
        'country',
        'place',
        'status',
        'created_at',
    ];

    protected $filterable = [
        'name' => 'like',
        'user_id' => 'equal',
        'status' => 'equal',
    ];

    protected $searchable = [
        'name', 'email',
    ];

    public $mediaMultipleCollections = ['images'];

    public static $slugSourceFields = ['name'];

    public static function statusesList(): array
    {
        return [
            self::SERVICE_PUBLISHED => 'Одобрено',
            self::SERVICE_MODERATE => 'На модерации',
            self::SERVICE_REJECTED => 'Отклонено',
            self::SERVICE_DRAFT => 'Черновик',
        ];
    }

    public static function servicesList(): array
    {
        return [
            'other' => 'Прочее',
            'tuning' => 'Тюнинг и дооснащение',
            'autoGlass' => 'Автостекла',
            'bodyRepair' => 'Кузовной ремонт',
            'diagnostics' => 'Диагностика',
            'engineRepair' => 'Ремонт двигателя',
            'carWashAndCare' => 'Мойка и уход за авто',
            'runningGearRepair' => 'Ремонт ходовой части',
            'transmissionRepair' => 'Ремонт трансмиссии',
            'repairOfElectricalSystems' => 'Ремонт електросистем',
        ];
    }

    public function getPerPage()
    {
        if (request('limit')) {
            return request('limit');
        } elseif (request('per_page')) {
            return request('per_page');
        }

        return $this->perPage;
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

        $var = Variable::getArray('seo_masks', null, $this->lang);

        return [
            'title' => $var['services']['fields']['title'] ?? '',
            'description' => $var['services']['fields']['description'] ?? '',
            'keywords' => $var['services']['fields']['keywords'] ?? '',
            'robots' => 'index',
        ];
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

    public function getAllConversions(string $collectionName = 'image', $isMain = true)
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

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    public function phones()
    {
        return $this->morphMany(Phone::class, 'model');
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function subscribers()
    {
        return $this->morphMany(Subscription::class, 'subscription');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }

    public function scopeSortService($query, $status)
    {
        if ($status == 'published') {
            return $query->orderByDesc('created_at');
        }

        return $query->orderByDesc('updated_at');
    }

    public function setServiceAttribute($services): void
    {
        $servicesBooleanObject = new stdClass();

        foreach ($services as $key => $value) {
            $servicesBooleanObject->$key = comparison_boolean_value($value);
        }

        $this->attributes['service'] = json_encode($servicesBooleanObject);
    }

    public function clearMediaCollectionMain(string $collectionName = 'default'): self
    {
        $this->getMedia($collectionName)->where('is_main', 1)
            ->each->delete();

        return $this;
    }

    public function scopeFilterable($query, array $attrs = []): void
    {
        foreach ($attrs as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if ($key === 'latitude' || $key === 'longitude' || $key === 'radius') {
                if (!empty($attrs['latitude']) && !empty($attrs['longitude'])) {
                    $latitude = $attrs['latitude'];
                    $longitude = $attrs['longitude'];

                    $radius = $attrs['radius'];
                    if (empty($radius) || $radius < 10) {
                        $radius = 10;
                    }
                    if (!empty($radius)) {
                        $haversine = '(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude))))';
                        $query
//                   ->selectRaw("{$haversine} AS distance")
                            ->select('*')
                            ->whereRaw("{$haversine} < ?", [$radius]);
                    }
                }
            } else {
                $query->where($key, $value);
            }
        }
    }
}
