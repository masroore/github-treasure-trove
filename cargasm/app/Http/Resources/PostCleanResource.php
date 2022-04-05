<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCleanResource extends JsonResource
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
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'text' => $this->text,
            'comment_allowed' => $this->comment_allowed,
            'status' => $this->status,
            'lang' => $this->lang,
            'translations' => PostTranslationResource::collection($this->whenLoaded('translations')),
            'main_photo' => $this->getAllConversions(),
            'author' => AuthorResource::make($this->whenLoaded('author')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
