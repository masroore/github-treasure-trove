<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostShowUserResource extends JsonResource
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
            'title' => $this->title,
            'user_id' => $this->user_id,
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'text' => $this->text,
            'comment_allowed' => $this->comment_allowed,
            'status' => $this->status,
            'post_type' => $this->post_type,
            'lang' => $this->lang,
            'translations' => PostTranslationResource::collection($this->whenLoaded('translations')),
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            //            'favorite' => $this->when(optional(auth()->user())->favoritePost($this->id), true, false),
            'favorite' => $this->when(optional(auth()->user())->hasFavoritePost($this->resource), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedPost($this->resource), true, false),
            'main_photo' => $this->getAllConversions(),
            'author' => AuthorResource::make($this->whenLoaded('author')),
            'msg_reject' => $this->msg_reject,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shares' => SharesResource::collection($this->user->shares),
            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->text)))), 0, 300), 'UTF-8', 'UTF-8')),
        ];
    }
}
