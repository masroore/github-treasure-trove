<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;

class CarBrandResource extends JsonResource
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
            'status' => $this->status,
            'models' => CarModelResource::collection($this->whenLoaded('models')),
            //            'photo' => new MediaResource($this->whenLoaded('media', function () {
            //                return $this->getFirstMedia('photo');
            //            })),
            //            'seo' => new SeoEditResource($this->whenLoaded('seo')),
        ];
    }
}
