<?php

namespace App\Http\Resources\Control;

use App\Http\Resources\PhoneResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceEditResource extends JsonResource
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
            'country' => $this->country,
            'place' => $this->place,
            'street' => $this->street,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'working' => $this->working,
            'descr' => $this->descr ?? '',
            'service' => $this->service,
            'video' => $this->video,
            'social' => $this->social,
            'lang' => $this->lang,
            'phones' => PhoneResource::collection($this->phones),

            'status' => $this->status,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'is_sitemap' => $this->is_active,
            'msg_reject' => $this->msg_reject,
            'user_id' => $this->user_id,

            'photo' => new MediaResource($this->whenLoaded('media', function () {
                return $this->getMainMedia('photos');
            })),
            'photos' => MediaResource::collection($this->whenLoaded('media')),
            'user' => new UserResource($this->whenLoaded('user')),
            'seo' => new SeoEditResource($this->whenLoaded('seo')),
        ];
    }
}
