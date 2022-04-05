<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    protected $shares_user;

    protected $shares_text;

    protected $type;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'entity_type' => 'event',
            'id' => $this->id,
            'title' => $this->title,
            'descr' => $this->descr,
            'status' => $this->status,
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'country' => $this->country,
            'place' => $this->place,
            'street' => $this->street,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'coauthor' => AuthorResource::make(User::where('id', $this->coauthor)->first()),
            'category' => $this->getCategoryStr(),
            //            'is_privacy' => $this->getPrivacyStr(),
            'is_privacy' => $this->is_privacy,
            'comment_allowed' => $this->comment_allowed,
            'confirm_user' => $this->confirm_user,
            'chat_allowed' => $this->chat_allowed,
            'photos_allowed' => $this->photos_allowed,
            'count_seats' => $this->count_seats,
            'users' => $this->getAllowedUsers(),
            'age' => $this->getAgeStr(),
            'sex' => $this->getGenderStr(),
            'created_at' => $this->created_at,
            'dates' => $this->dates,
            'dates_count' => count($this->dates),
            'self_schedule_dates' => $this->self_schedule_dates,
            'dates_continuous' => $this->dates_continuous,
            'more_days' => $this->more_days,
            'lang' => $this->lang,
            'main_photo' => $this->getAllConversions(),
            'photos' => Media::collection($this->getMedia('images')),
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'favorites_likes_count' => $this->likeable_count,
            'favorites_comments_count' => $this->comment_count,
            //            'favorites_count' => $this->favorites_count,
            'favorite' => $this->when(optional(auth()->user())->hasFavoriteEvent($this->resource), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedEvent($this->resource), true, false),
            'main_photo' => $this->getAllConversions(),
            'photos' => Media::collection($this->getMedia('images')),
            'photos_users' => Media::collection($this->getMedia('images_users')),
            'photos_author' => Media::collection($this->getMedia('images_author')),
            //            'author' => AuthorResource::make($this->whenLoaded('user')),
            'external_source' => $this->external_source,
            'author' => AuthorResource::make($this->user),
            'external' => $this->when($this->external_source == true, $this->external),
            'is_invite' => $this->when(optional(auth()->user())->hasApplicationSend($this->resource), optional(optional($this->users()->find(auth()->user()))->pivot)->user_status, Event::STATUS_USER_FORBIDDEN),
            'to_slider' => $this->to_slider,
            'shares' => SharesResource::collection($this->shares),
            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->descr)))), 0, 300), 'UTF-8', 'UTF-8')),

            'share_user' => $this->when(isset($this->shares_user) && $this->type === Timeline::TYPE_SHARE, function () {
                return AuthorResource::make($this->shares_user);
            }),
            'share_text' => $this->when(isset($this->shares_text) && $this->type === Timeline::TYPE_SHARE, function (): void {
                $this->shares_text;
            }),
            'type' => $this->when(isset($this->type), function () {
                return $this->type;
            }),
        ];
    }

    public function setAttrs($type, $shares_user, $shares_text)
    {
        $this->type = $type;
        $this->shares_user = $shares_user;
        $this->shares_text = $shares_text;

        return $this;
    }
}
