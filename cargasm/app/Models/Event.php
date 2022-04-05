<?php

namespace App\Models;

use App\Http\Resources\AuthorResource;
use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSeoTrait;
use App\Models\Traits\HasSlugTrait;
use App\Models\Traits\HasStaticLists;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Variable;

class Event extends Model implements HasMedia
{
    use Filterable;
    use HasLang;
    use HasMediaTrait;
    use HasSeoTrait;
    use HasSlugTrait;
    use HasStaticLists;

    public static $slugSourceFields = ['title'];

    protected $guarded = ['id'];

    public const TYPE_SELF = 'self';
    public const TYPE_ATTEMPT = 'attempt';

    public const EVENT_OPEN = 'open';
    public const EVENT_CLOSE = 'close';

    public const STATUS_USER_FORBIDDEN = 'forbidden';
    public const STATUS_USER_ALLOWED = 'allowed';
    public const STATUS_USER_WAITING = 'waiting';

    public const CONFIRM_USER_AUTO = 1;
    public const CONFIRM_USER_MANUALLY = 0;

    public const STATUS_WAIT = 'waiting';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PASSED = 'passed';

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const GENDER_ALL = 'all';

    public const AGE_16 = '16';
    public const AGE_18 = '18';
    public const AGE_ALL = 'all';

    protected $casts = [
        'coauthor' => 'array',
        'social' => 'array',
        'confirm_user' => 'boolean',
        'confirm_user' => 'boolean',
        'comment_allowed' => 'boolean',
        'chat_allowed' => 'boolean',
        'photos_allowed' => 'boolean',
        'self_schedule_dates' => 'boolean',
        'more_days' => 'boolean',
        'dates_continuous' => 'boolean',
        'dates' => 'array',
        'external' => 'array',
    ];

    protected $filterable = [
        'title' => 'like',
    ];

    protected $searchable = [
        'nickname',
    ];

    public $mediaMultipleCollections = ['images'];

    public static function categoryList(): array
    {
        return [
            [
                'name' => 'Выставки',
                'value' => 'showing',
            ],
            [
                'name' => 'Встречи',
                'value' => 'meet',
            ],
            [
                'name' => 'Концерты',
                'value' => 'concerts',
            ],
            [
                'name' => 'Праздники',
                'value' => 'holidays',
            ],
            [
                'name' => 'Фестивали',
                'value' => 'festivals',
            ],
            [
                'name' => 'Личные встречи',
                'value' => 'personaleMetings',
            ],
        ];
    }

    public static function ageList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::AGE_16,
                'name' => trans('system.event.age.16'),
            ],
            [
                'key' => self::AGE_18,
                'name' => trans('system.event.age.18'),
            ],
            [
                'key' => self::AGE_ALL,
                'name' => trans('system.event.age.all'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

//    public static function authorTypeList(string $columnKey = null, string f$indexKey = null): array
//    {
//        $records = [
//            [
//                'key' => self::AUTHOR_USER,
//                'name' => trans('system.event.author.user'),
//            ],
//            [
//                'key' => self::AUTHOR_EXTERNAL,
//                'name' => trans('system.event.author.external'),
//            ],
//        ];
//
//        return self::staticListBuild($records, $columnKey, $indexKey);
//    }

    public function getAgeStr(): string
    {
        return self::ageList('name', 'key')[$this->age] ?? '';
    }

    public static function genderList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::GENDER_MALE,
                'name' => trans('system.event.gender.male'),
            ],
            [
                'key' => self::GENDER_FEMALE,
                'name' => trans('system.event.gender.female'),
            ],
            [
                'key' => self::GENDER_ALL,
                'name' => trans('system.event.gender.all'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getGenderStr(): string
    {
        return self::genderList('name', 'key')[$this->sex] ?? '';
    }

    public static function confirmList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::CONFIRM_USER_AUTO,
                'name' => trans('system.event.confirm.auto'),
            ],
            [
                'key' => self::CONFIRM_USER_MANUALLY,
                'name' => trans('system.event.confirm.manually'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getConfirmStr(): string
    {
        return self::confirmList('name', 'key')[$this->status] ?? '';
    }

    public static function categoryListValue(): array
    {
        return [
            'showing' => 'Выставки',
            'meet' => 'Встречи',
            'concerts' => 'Концерты',
            'holidays' => 'Праздники',
            'festivals' => 'Фестивали',
            'personaleMetings' => 'Личные встречи',
            'all' => 'Не имеет значения',
        ];
    }

    public static function countSeatsList(): array
    {
        return [
            [
                'key' => 10,
                'value' => '1-10',
            ],
            [
                'key' => 20,
                'value' => '10-20',
            ],
            [
                'key' => 50,
                'value' => '20-50',
            ],
            [
                'key' => 100,
                'value' => '50-100',
            ],
            [
                'key' => 101,
                'value' => '100 и более',
            ],
            [
                'key' => 1001,
                'value' => 'без ограничений',
            ],

        ];
    }

    public static function privacyList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::EVENT_OPEN,
                'name' => trans('system.event.privacy.open'),
            ],
            [
                'key' => self::EVENT_CLOSE,
                'name' => trans('system.event.privacy.close'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getPrivacyStr(): string
    {
        return self::privacyList('name', 'key')[$this->is_privacy] ?? '';
    }

    public function getCategoryStr(): string
    {
        return self::categoryListValue()[$this->category] ?? '';
    }

    public static function statusesUserList(): array
    {
        return [
            self::STATUS_USER_ALLOWED => 1,
            self::STATUS_USER_FORBIDDEN => 0,
        ];
    }

    public static function statusesList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::STATUS_USER_ALLOWED,
                'name' => trans('system.status.allowed'),
            ],
            [
                'key' => self::STATUS_USER_FORBIDDEN,
                'name' => trans('system.status.forbidden'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getStatusStr(): string
    {
        return self::statusesList('name', 'key')[$this->status] ?? '';
    }

    public static function statusesActiveList(?string $columnKey = null, ?string $indexKey = null): array
    {
        $records = [
            [
                'key' => self::STATUS_WAIT,
                'name' => trans('system.event.status.waiting'),
            ],
            [
                'key' => self::STATUS_ACTIVE,
                'name' => trans('system.event.status.active'),
            ],
            [
                'key' => self::STATUS_PASSED,
                'name' => trans('system.event.status.passed'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }

    public function getStatusActiveStr(): string
    {
        return self::statusesActiveList('name', 'key')[$this->status] ?? '';
    }

    public function isOpen(): bool
    {
        return $this->is_privacy === self::EVENT_OPEN;
    }

    public function isClose(): bool
    {
        return $this->is_privacy === self::EVENT_CLOSE;
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

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_users')->withPivot('user_status');
    }

    //Все события
    public function eventsful()
    {
        return $this->belongsToMany(User::class, 'eventfuls')->withPivot('type');
    }

    public function getEventUserStatus(User $user)
    {
        return $this->users()->find($user)->pivot->user_status;
    }

    public function getAllowedUsers()
    {
        $users = [];
        foreach ($this->users->whereIn('pivot.user_status', [self::STATUS_USER_ALLOWED]) as $user) {
            $user = AuthorResource::make($user);
            $users[] = $user;
        }

        return $users;
    }

    public function getForbiddenUsers()
    {
        $users = [];
        foreach ($this->users->whereIn('pivot.user_status', [self::STATUS_USER_FORBIDDEN, self::STATUS_USER_WAITING]) as $user) {
            $user = AuthorResource::make($user);
            $users[] = $user;
        }

        return $users;
    }

    public function getAllUsers()
    {
        $users = [];
        foreach ($this->users()->get() as $user) {
            $user = AuthorResource::make($user);
            $users[] = $user;
        }

        return $users;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function allowComment()
    {
        return $this->comment_allowed;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 360, 200)
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

    public function scopeFilterable($query, array $attrs = []): void
    {
        $events = self::select('id', 'dates')->get()->toArray();
        foreach ($attrs as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if ($key === 'categories') {
                $value = is_array($value) ? $value : [$value];
                if ($value['0'] != 'all') {
                    $query->whereIn('category', array_values($value));
                }
            } elseif ($key === 'count_seats') {
                $value = is_array($value) ? $value : [$value];

                if ($value['0'] === '10') {
                    $query->where('count_seats', '>', 0)->where('count_seats', '<=', 10);
                } elseif ($value['0'] === '20') {
                    $query->where('count_seats', '>', 10)->where('count_seats', '<=', 20);
                } elseif ($value['0'] === '50') {
                    $query->where('count_seats', '>', 20)->where('count_seats', '<=', 50);
                } elseif ($value['0'] === '100') {
                    $query->where('count_seats', '>', 50)->where('count_seats', '<=', 100);
                } elseif ($value['0'] === '101') {
                    $query->where('count_seats', '>', 100);
                }
            } elseif ($key === 'period') {
                $ids = [];
                if ($value === 'today') {
                    foreach ($events as $item) {
                        //проверка события на текущую дату
                        foreach ($item['dates']['items'] as $date) {
                            if (Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['from'])->lte(Carbon::now()->setSecond(0)) && Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['to'])->gte(Carbon::now()->setSecond(0))) {
                                if (Carbon::parse($date['time']['to'])->gte(Carbon::now()->setSecond(0)) && Carbon::parse($date['time']['to'])->lt(Carbon::now()->endOfDay())) {
                                    $ids[] = $item['id'];
                                }
                            }
                        }
                    }
                } elseif ($value === 'this_week') {
                    foreach ($events as $item) {
                        foreach ($item['dates']['items'] as $date) {
                            if (Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['to'])->gt(Carbon::now()) && Carbon::parse(Carbon::parse($date['date'])->toDateString() . ' ' . $date['time']['to'])->lt(Carbon::now()->endOfWeek())) {
                                $ids[] = $item['id'];
                            }
                        }
                    }
                } elseif ($value === 'weekend') {
                    foreach ($events as $item) {
                        foreach ($item['dates']['items'] as $date) {
                            if (Carbon::parse($date['date'])->startOfDay()->gte(Carbon::now()->startOfWeek()->addDays(5)) && Carbon::parse($date['date'])->lte(Carbon::now()->endOfWeek())) {
                                $ids[] = $item['id'];
                            }
                        }
                    }
                }

//                if (count($ids)) {
                $query->whereIn('id', $ids);
//                }
            } elseif ($key === 'locations') {
                $latitude = $value['latitude'];
                $longitude = $value['longitude'];
                if (!empty($value['radius'])) {
                    $radius = $value['radius'];
                }
                if (!empty($latitude) && !empty($longitude) && !empty($radius)) {
                    $haversine = '(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude))))';
                    $query
                        ->selectRaw("{$haversine} AS distance")
                        ->whereRaw("{$haversine} < ?", [$radius]);
                }
            } elseif ($key === 'date') {
                $ids = [];
                foreach ($events as $item) {
                    if (Carbon::parse($item['dates']['date']['from'])->startOfDay()->gt(Carbon::parse($value['to']))) {
                        $ids = [];
                    } elseif (Carbon::parse($item['dates']['date']['to'])->endOfDay()->lt(Carbon::parse($value['from']))) {
                        $ids = [];
                    } else {
                        $ids[] = $item['id'];
                    }
                }
                if (count($ids)) {
                    $query->whereIn('id', $ids);
                }
            } elseif ($key === 'place') {
                $query->where($key, 'like', $value);
            } elseif ($key === 'status') {
                if ($value === self::STATUS_ACTIVE) {
                    $query->whereIn('status', [self::STATUS_ACTIVE, self::STATUS_WAIT]);
                } else {
                    $query->where($key, $value);
                }
            } else {
                $query->where($key, $value);
            }
        }
    }

    public function scopeFilter($query, $filter)
    {
        if ($filter === 'date') {
            return $query->orderByDesc('created_at');
        }
        if ($filter === 'title') {
            return $query->orderByDesc('created_at');
        }
        if ($filter === 'address') {
            return $query->orderByDesc('created_at');
        }

        if ($filter === 'is_privacy') {
            return $query->orderByDesc('created_at');
        }

        if ($filter === 'confirm_user') {
            return $query->orderByDesc('created_at');
        }
        if ($filter === 'age') {
            return $query->orderByDesc('created_at');
        }
        if ($filter === 'category') {
            return $query->orderByDesc('created_at');
        }
        if ($filter === 'sex') {
            return $query->orderByDesc('created_at');
        }

        return $query->orderByDesc('created_at');
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
            'title' => $var['event']['fields']['title'] ?? '[node:title]',
            'description' => $var['event']['fields']['description'] ?? '',
            'keywords' => $var['event']['fields']['keywords'] ?? '',
            'robots' => 'index',
        ];
    }
}
