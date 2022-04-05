<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaForTinyBox extends JsonResource
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

            'url' => $this->getFullUrl(),
            'src' => $this->getFullUrl(), // TODO remove
            'is_main' => $this->is_main,
            'is_active' => $this->is_active,
            'alt' => $this->custom_properties['alt'] ?? '',
            'title' => $this->custom_properties['title'] ?? '',

            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'size' => $this->size,
        ];
    }
}
