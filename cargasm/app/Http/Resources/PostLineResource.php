<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use Illuminate\Http\Resources\Json\JsonResource;

class PostLineResource extends JsonResource
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
            'user_id' => $this->timelines->user_id,
            'type' => $this->type,
            'title' => $this->timelines->title,
            'uuid' => $this->timelines->uuid,
            'slug' => $this->timelines->slug,
            'text' => clean_text($this->timelines->text),
            'comment_allowed' => $this->timelines->comment_allowed,
            'status' => $this->timelines->status,
            'post_type' => $this->timelines->post_type,
            'lang' => $this->timelines->lang,
            'likes_count' => $this->timelines->likeable_count,
            'comments_count' => $this->timelines->comment_count,
            //            'favorites_likes_count' => $this->likeable_count,
            //            'favorites_comments_count' => $this->comment_count,
            //            'favorites_count' => $this->favorites_count,
            'favorite' => $this->when(optional(auth()->user())->hasFavoritePost($this->timelines), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedPost($this->timelines), true, false),
            'main_photo' => $this->timelines->getAllConversions(),
            'author' => AuthorResource::make($this->timelines->author),
            'msg_reject' => $this->timelines->msg_reject,
            'created_at' => $this->timelines->created_at,
            'updated_at' => $this->timelines->updated_at,
            'share_user' => $this->when($this->type === Timeline::TYPE_SHARE, AuthorResource::make($this->user)),
            'share_text' => $this->when($this->type === Timeline::TYPE_SHARE, $this->description),
            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->timelines->text)))), 0, 300), 'UTF-8', 'UTF-8')),
        ];
    }
}
