<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'is_main' => (bool) $this->is_main,
            'is_active' => (bool) $this->is_active,
            'alt' => $this->custom_properties['alt'] ?? '',
            'title' => $this->custom_properties['title'] ?? '',
            'weight' => $this->order_column,

            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'size' => $this->size,
        ];
    }
}
