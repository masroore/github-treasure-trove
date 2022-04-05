<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventLineResource extends JsonResource
{
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
            'id' => $this->timelines->id,
            'type' => $this->type,
            'title' => $this->timelines->title,
            'descr' => $this->timelines->descr,
            'status' => $this->timelines->status,
            'uuid' => $this->timelines->uuid,
            'slug' => $this->timelines->slug,
            'country' => $this->timelines->country,
            'place' => $this->timelines->place,
            'street' => $this->timelines->street,
            'address' => $this->timelines->address,
            'latitude' => $this->timelines->latitude,
            'longitude' => $this->timelines->longitude,
            'coauthor' => AuthorResource::make(User::where('id', $this->timelines->coauthor)->first()),
            'category' => $this->timelines->getCategoryStr(),
            //            'is_privacy' => $this->timelines->getPrivacyStr(),
            'is_privacy' => $this->timelines->is_privacy,
            'comment_allowed' => $this->timelines->comment_allowed,
            'confirm_user' => $this->timelines->confirm_user,
            'chat_allowed' => $this->timelines->chat_allowed,
            'photos_allowed' => $this->timelines->photos_allowed,
            'count_seats' => $this->timelines->count_seats,
            'users' => $this->timelines->getAllowedUsers(),
            'age' => $this->timelines->getAgeStr(),
            'sex' => $this->timelines->getGenderStr(),
            'created_at' => $this->timelines->created_at,
            'dates' => $this->timelines->dates,
            'dates_count' => count($this->timelines->dates),
            'self_schedule_dates' => $this->timelines->self_schedule_dates,
            'dates_continuous' => $this->timelines->dates_continuous,
            'more_days' => $this->timelines->more_days,
            'lang' => $this->timelines->lang,
            'main_photo' => $this->timelines->getAllConversions(),
            'photos' => Media::collection($this->timelines->getMedia('images')),
            'likes_count' => $this->timelines->likeable_count,
            'comments_count' => $this->timelines->comment_count,
            'favorites_count' => $this->timelines->favorites_count,
            'favorite' => $this->when(optional(auth()->user())->hasFavoriteEvent($this->timelines), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedEvent($this->timelines), true, false),
            //            $user->hasLikedEvent($events->timelines),
            'main_photo' => $this->timelines->getAllConversions(),
            'photos' => Media::collection($this->timelines->getMedia('images')),
            'photos_users' => Media::collection($this->timelines->getMedia('images_users')),
            'photos_author' => Media::collection($this->timelines->getMedia('images_author')),
            //            'author' => AuthorResource::make($this->timelines->user),
            'external_source' => $this->external_source,
            'author' => AuthorResource::make($this->user),
            'external' => $this->when($this->external_source == true, $this->external),
            'is_invite' => $this->when(optional(auth()->user())->hasApplicationSend($this->timelines), true, false),
            'to_slider' => $this->timelines->to_slider,
            'share_user' => $this->when($this->type === Timeline::TYPE_SHARE, AuthorResource::make($this->user)),
            'share_text' => $this->when($this->type === Timeline::TYPE_SHARE, $this->description),
            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->timelines->descr)))), 0, 300), 'UTF-8', 'UTF-8')),
        ];
    }
}
