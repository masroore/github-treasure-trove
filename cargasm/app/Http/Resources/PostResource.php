<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'entity_type' => 'post',
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'text' => $this->text,
            'comment_allowed' => $this->comment_allowed,
            'status' => $this->status,
            'post_type' => $this->post_type,
            'lang' => $this->lang,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'favorites_likes_count' => $this->likeable_count,
            'favorites_comments_count' => $this->comment_count,
            //            'favorites_count' => $this->favorites_count,
            'favorite' => $this->when(optional(auth()->user())->hasFavoritePost($this->resource), true, false),
            'like' => $this->when(optional(auth()->user())->hasLikedPost($this->resource), true, false),
            'main_photo' => $this->getAllConversions(),
            'author' => AuthorResource::make($this->author),
            'msg_reject' => $this->msg_reject,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shares' => SharesResource::collection($this->shares),
            'share_user' => $this->when(isset($this->shares_user), function () {
                if (isset($this->type)) {
                    if ($this->type === Timeline::TYPE_SHARE) {
                        return AuthorResource::make($this->shares_user);
                    }
                }
            }),
            'share_text' => $this->when(isset($this->shares_text), function () {
                if (isset($this->type)) {
                    if ($this->type === Timeline::TYPE_SHARE) {
                        return $this->shares_text;
                    }
                }
            }),
            'type' => $this->when(isset($this->type), function () {
                return $this->type;
            }),

            'announce' => html_entity_decode(mb_convert_encoding(substr(trim(preg_replace('/\s+/', ' ', preg_replace('/<\/?[^>]+>/', ' ', preg_replace('/<figcaption\b[^>]*>(.*?)<\/figcaption>/i', '', $this->text)))), 0, 300), 'UTF-8', 'UTF-8')),
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
