<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'slug' => $this->slug,
            'rating' => round($this->ratings->avg('score'), 2),
            'number_votes' => $this->ratings->count(),
            'email' => $this->email,
            'country' => $this->country,
            'place' => $this->place,
            'street' => $this->street,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'working' => $this->working,
            'service' => $this->service,
            'lang' => $this->lang,
            'main_photo' => $this->getAllConversions(),
            'photos' => Media::collection($this->getMedia('images')),
            'status' => $this->status,
            'type' => $this->type,
            'msg_reject' => $this->msg_reject,
            'descr' => $this->descr,
        ];
    }
}
