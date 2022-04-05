<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'likes_count' => $this->likes_count,
            'like' => $this->when(optional(auth()->user())->hasLikedComment($this->resource), true, false),
            'text' => $this->text,
            'author' => AuthorResource::make($this->whenLoaded('user')),
            'user' => $this->parent && $this->parent->user ? AuthorResource::make($this->parent->user) : null,
            'children' => !empty($this->children) ? self::collection($this->children) : [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
