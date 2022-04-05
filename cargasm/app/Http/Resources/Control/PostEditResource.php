<?php

namespace App\Http\Resources\Control;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class PostEditResource extends JsonResource
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
            'slug' => $this->slug,
            'text' => $this->text ?? '',
            'comment_allowed' => $this->comment_allowed,
            'status' => $this->status,
            'post_type' => $this->post_type,
            'lang' => $this->lang,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'service_id' => $this->author_type === Service::class
                ? $this->author_id
                : null,
            'service' => $this->when($this->relationLoaded('author') && $this->author_type === Service::class, function () {
                return new ServiceResource($this->author);
            }),
            'msg_reject' => $this->msg_reject,
            'photo' => new MediaResource($this->whenLoaded('media', function () {
                return $this->getFirstMedia('photo');
            })),
            'author' => PostAuthorResource::make($this->whenLoaded('author')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
