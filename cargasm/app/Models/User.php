<?php

namespace App\Models;

use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\SetPasswordAttributeTrait;
use App\Notifications\ResetPassword as ResetPasswordWithDomain;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Fomvasss\Filterable\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use stdClass;

/**
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $name
 * @property string $surname
 * @property string $nickname
 * @property string $about
 * @property string $social
 * @property string $notice
 * @property string $privacy
 * @property int $role
 * @property bool $active
 * @property string $email_verified_at
 * @property Carbon $created_at
 * @property Carbon updated_at
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Filterable;
    use HasApiTokens;
    use HasMediaTrait;
    use HasPushSubscriptions;
    use Notifiable;
    use SetPasswordAttributeTrait;
    use Sortable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social' => 'array',
        'notice' => 'array',
        'privacy' => 'array',
        'settings' => 'array',
        'address' => 'array',
    ];

    protected $sortable = [
        'id',
        'name',
        'role',
        'phone',
        'email',
        'status',
        'created_at',
    ];

    protected $searchable = [
        'name', 'email', 'nickname', 'surname',
    ];

    public $userDefaultImagePath = '/images/default_avatar.png';

    public $mediaSingleCollections = ['avatar'];

//    public const USER_ACTIVE = 1;
//    public const USER_BLACKOUT = 0;

    const STATUS_APPROVED = 'approved';
    const STATUS_MODERATION = 'moderation';
    const STATUS_BANNED = 'banned';

    public const ROLE_USER = 'user';
    public const ROLE_PARTNER = 'partner';
    public const ROLE_ADMIN = 'admin';

    const EVENT_STATUS_APPROVED = 'разрешен';
    const EVENT_STATUS_MODERATION = 'moderation';

    public static function rolesList(): array
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_PARTNER => 'Partner',
            self::ROLE_USER => 'User',
        ];
    }

    public static function statusesList(): array
    {
        return [
            self::STATUS_APPROVED => 'Одобрен',
            self::STATUS_BANNED => 'Заблокирован',
            self::STATUS_MODERATION => 'На модерации',
        ];
    }

    public static function eventStatusesList(): array
    {
        return [
            self::EVENT_STATUS_APPROVED => 'Одобрен',
            self::EVENT_STATUS_MODERATION => 'На модерации',
        ];
    }

    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordWithDomain($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }

    public function setPhoneAttribute($value): void
    {
        if ($value) {
            $this->attributes['phone'] = preg_replace('/[^0-9]/', '', $value);
        } else {
            $this->attributes['phone'] = null;
        }
    }

    /**
     * Specifies the user's FCM token.
     *
     * @return array|string
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 165, 165)
            ->performOnCollections('avatar')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('avatar')
            ->nonQueued();
    }

    public function getAllConversions(string $collectionName = 'avatar', $isMain = false)
    {
        /** @var Media $media */
//        $media = $isMain
//            ? $this->getMainMedia($collectionName)
//            : $media = $this->getFirstMedia($collectionName);

        $media = $this->getFirstMedia($collectionName);

        return [
            'avatar' => $this->getFirstMediaUrl($collectionName, 'preview') ?: url('/images/default-avatar.jpg'),
            'min_avatar' => $this->getFirstMediaUrl($collectionName, 'thumb') ?: url('/images/default-avatar-min_avatar.jpg'),
            'default_img' => $this->getFirstMediaUrl($collectionName, 'preview') ? false : true,
            'alt' => $media ? $media->custom_properties['alt'] ?? '' : '',
            'title' => $media ? $media->custom_properties['title'] ?? '' : '',
        ];
    }

    public function notifies()
    {
        return $this->morphMany(Notify::class, 'notifiable');
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function phones()
    {
        return $this->morphMany(Phone::class, 'model');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscribers()
    {
        return $this->morphMany(Subscription::class, 'subscription');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'author');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_users')->withPivot('user_status');
    }

    public function eventsful()
    {
        return $this->belongsToMany(Event::class, 'eventfuls')->withPivot('type');
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function postsOfUser()
    {
        return $this->hasMany(Post::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'addressee', 'id');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'first', 'id');
    }

//    public function isInConversation($id)
//    {
//        return (bool) $user->favorites
//        ->where('user_id', $this->id)
//        ->count();
//    }

    public function banUsers()
    {
        return $this->hasMany(Bans::class);
    }

    public function complaints()
    {
        return $this->morphMany(Complaint::class, 'complaintable');
    }

//    public function getEventUserStatus(Event $event) {
//        return $this->events()->find($event)->pivot->user_status;
//    }

    public function hasFavoritePost(Post $post)
    {
        return (bool) $post->favorites
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasFavoriteEvent(Event $event)
    {
        return (bool) $event->favorites
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedPhoto(Photo $photo)
    {
        return (bool) $photo->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedPost(Post $post)
    {
        return (bool) $post->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasSharePost(Post $post)
    {
        return (bool) $post->shares
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasSharePhoto(Photo $photo)
    {
        return (bool) $photo->shares
            ->where('user_id', $this->id)
            ->count();
    }

    public function isMainPost(Post $post): bool
    {
        return $post->user_id === $this->id;
    }

    public function isMainEvent(Event $event): bool
    {
        return $event->user_id === $this->id;
    }

    public function isMainPhoto(Photo $photo): bool
    {
        return $photo->user_id === $this->id;
    }

    public function hasShareEvent(Event $event)
    {
        return (bool) $event->shares
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedEvent(Event $event)
    {
        return (bool) $event->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedRating(Rating $rating)
    {
        return (bool) $rating->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasLikedComment(Comment $comment)
    {
        return (bool) $comment->likes
            ->where('user_id', $this->id)
            ->count();
    }

    public function hasApplicationSend(Event $event)
    {
        return (bool) $event->users
            ->where('id', $this->id)
//            ->where('user_status', Event::STATUS_USER_WAITING)
            ->count();
    }

    public function hasComplaintPost(Post $post)
    {
        return (bool) $post->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintEvent(Event $event)
    {
        return (bool) $event->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintUser(self $user)
    {
        return (bool) $user->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintService(Service $service)
    {
        return (bool) $service->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintRating(Rating $rating)
    {
        return (bool) $rating->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintCar(Car $car)
    {
        return (bool) $car->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

    public function hasComplaintComment(Comment $comment)
    {
        return (bool) $comment->complaints
            ->where('user_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->count();
    }

//    public function checkLikePost($id)
//    {
//        return $this->likes()->where('entity_type', 'App\Models\Post')->where('entity_id', $id)->count() ? true : false;
//    }

//    public function checkLikeComment($id)
//    {
//        return $this->likes()->where('likeable_type', 'App\Models\Comment')->where('likeable_id', $id)->count() ? true : false;
//    }

    public function checkFeedbackService($id)
    {
        return $this->ratings()->where('service_id', $id)->count() ? true : false;
    }

    public function checkSubscription($type, $id)
    {
        return $this->subscriptions()->where('subscription_type', $type === 'user' ? 'App\Models\User' : 'App\Models\Service')->where('subscription_id', $id)->count() ? true : false;
    }

    public function checkSubscriptionsForUser($id)
    {
        return $this->subscriptions()->where('subscription_type', 'App\Models\User')->where('subscription_id', $id)->count() ? true : false;
    }

    public function checkBanUser($id)
    {
        return $this->banUsers()->where('ban_user_id', $id)->count() ? true : false;
    }

    public function checkCallback($id)
    {
        return $this->ratings()->where('service_id', $id)->count() ? true : false;
    }

    public function setPrivacyAttribute($privacy): void
    {
        $privacyBooleanObject = new stdClass();

        foreach ($privacy as $key => $value) {
            $privacyBooleanObject->$key = comparison_boolean_value($value);
        }

        $this->attributes['privacy'] = json_encode($privacyBooleanObject);
    }

    public function getPrivacyValue(string $key): bool
    {
        return empty($this->privacy[$key]) !== true;
    }

    /**
     * Приватность.
     */
    public function getPrivacyValues(): array
    {
        return [
            'fio' => $this->getPrivacyValue('fio'),
            'phone' => $this->getPrivacyValue('phone'),
            'email' => $this->getPrivacyValue('email'),
            'social' => $this->getPrivacyValue('social'),
        ];
    }

    /**
     * Адресс.
     */
    public function getAddressValues(): array
    {
        return [
            'lat' => $this->address['location']['lat'] ?? '',
            'lng' => $this->address['location']['lng'] ?? '',
            'fullName' => $this->address['fullName'] ?? '',
            'city' => $this->address['city'] ?? '',
            'country' => $this->address['country'] ?? '',
        ];
    }

    /**
     * Настройки.
     */
    public function getSettingValues(): array
    {
        return [
            'new_message' => $this->setting['new_message'] ?? '',
            'blog_comment' => $this->setting['blog_comment'] ?? '',
            'blog_comment_response' => $this->setting['blog_comment_response'] ?? '',
            'blog_subscribe' => $this->setting['blog_subscribe'] ?? '',
            'blog_like' => $this->setting['blog_like'] ?? '',
            'blog_share' => $this->setting['blog_share'] ?? '',
            'event_new_participant' => $this->setting['blog_share'] ?? '',
            'event_reminder' => $this->setting['event_reminder'] ?? '',
            'event_comment' => $this->setting['event_comment'] ?? '',
            'event_comment_response' => $this->setting['event_comment_response'] ?? '',
            'event_begin' => $this->setting['event_begin'] ?? '',
            'event_cancel' => $this->setting['event_cancel'] ?? '',
            'event_change' => $this->setting['event_change'] ?? '',
            'event_share' => $this->setting['event_share'] ?? '',
        ];
    }

    /**
     * Социальные сети.
     */
    public function getSocialValues(): array
    {
        return [
            'ok' => $this->social['ok'] ?? '',
            'vk' => $this->social['vk'] ?? '',
            'youtube' => $this->social['youtube'] ?? '',
            'facebook' => $this->social['facebook'] ?? '',
        ];
    }

//    public function scopeByCurrentDomain($query)
//    {
//        $query->where(function ($q) {
//            $q->where('domain', optional(get_domain())->url)
//                ->orWhere('domain', null);
//        });
//    }
}
