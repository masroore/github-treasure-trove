<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;

class CarEditResource extends JsonResource
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

            'descr' => $this->descr ?? '',
            'vin' => $this->vin ?? '',
            'is_active' => $this->is_active,
            'is_sitemap' => $this->is_sitemap,
            'mark_id' => $this->mark_id,
            'model_id' => $this->model_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'photo' => new MediaResource($this->whenLoaded('media', function () {
                return $this->getMainMedia('photos');
            })),
            'photos' => MediaResource::collection($this->whenLoaded('media')),
            'brand' => new CarBrandResource($this->whenLoaded('brand')),
            'model' => new CarModelResource($this->whenLoaded('model')),
        ];
    }
}
