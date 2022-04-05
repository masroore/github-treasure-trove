<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            'entity_type' => 'photo',
            'id' => $this->id,
            'weight' => $this->weight,
            'title' => $this->title,
            'author' => AuthorResource::make($this->user),
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'lang' => $this->lang,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'lang' => $this->lang,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'favorites_likes_count' => $this->likeable_count,
            'favorites_comments_count' => $this->comment_count,
            'like' => $this->when(optional(auth()->user())->hasLikedPhoto($this->resource), true, false),
            'photo' => $this->getAllConversions(),
            //            'photo' => Media::collection($this->getMedia('images')),
            'album' => optional($this->album)->title,

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
