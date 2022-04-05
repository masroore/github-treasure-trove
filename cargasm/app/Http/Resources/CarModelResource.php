<?php

namespace App\Http\Resources;

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
            'is_popular' => true,
            'title' => $this->name,
            'url' => config('services.site') . 'catalog/' . $this->brend->name . '/' . $this,
        ];
    }
}
