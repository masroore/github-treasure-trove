<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
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
            'descr' => $this->descr,
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'lang' => $this->lang,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'main_photo' => $this->getAllConversions(),
            'author' => AuthorResource::make($this->user),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
