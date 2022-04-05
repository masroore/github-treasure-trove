<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostShowResource extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'text' => $this->text,
            'comment_allowed' => $this->comment_allowed,
            'post_type' => $this->post_type,
            'status' => $this->status,
            'lang' => $this->lang,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'favorites_count' => $this->favorites_count,
            'favorite' => $this->when(optional(auth()->user())->hasFavoritePost($this->resource), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedPost($this->resource), true, false),
            'subscribed' => $this->when(optional(auth()->user())->checkSubscription($this->author->getTable() === 'users' ? 'user' : 'service', $this->author->id), true, false),
            'translations' => PostTranslationResource::collection($this->whenLoaded('translations')),
            // 'main_photo' => new Media($this->whenLoaded('media', function () {
            //     return $this->getFirstMedia('photo');
            // })),//$this->getAllConversions(),
            'main_photo' => $this->getAllConversions(),
            'author' => AuthorResource::make($this->whenLoaded('author')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shares' => SharesResource::collection($this->user->shares),
            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->text)))), 0, 300), 'UTF-8', 'UTF-8')),
        ];
    }
}
