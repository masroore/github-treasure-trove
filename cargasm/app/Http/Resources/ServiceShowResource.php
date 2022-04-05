<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceShowResource extends JsonResource
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
            'email' => $this->email,
            'phones' => PhoneResource::collection($this->phones),
            'country' => $this->country,
            'place' => $this->place,
            'street' => $this->street,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'working' => $this->working,
            'descr' => $this->descr,
            'service' => $this->service,
            'video' => $this->video,
            'social' => $this->social,
            'status' => $this->status,
            'type' => $this->type,
            'lang' => $this->lang,
            'main_photo' => $this->getAllConversions(),
            'photos' => Media::collection($this->getMedia('images')),
            'rating' => round($this->ratings->avg('score'), 2),
            'number_votes' => $this->ratings->count(),
            'subscribed' => $this->when(optional(auth()->user())->checkSubscription('service', $this->id), true, false),
            'callback' => $this->when(optional(auth()->user())->checkCallback($this->id), true, false),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
