<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
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
            'name' => $this->name,
            'production_start' => $this->production_start,
            'production_end' => $this->production_end,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'parent' => $this->when($this->relationLoaded('parent'), function () {
                return CarBrandResource::make($this->parent);
            }),
            //            'photo' => new MediaResource($this->whenLoaded('media', function () {
            //                return $this->getFirstMedia('photo');
            //            })),
            'photos' => MediaResource::collection($this->whenLoaded('media')),

            'seo' => new SeoEditResource($this->whenLoaded('seo')),
        ];
    }
}
