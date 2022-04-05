<?php

namespace App\Http\Resources\Control;

use App\Http\Resources\PhoneResource;
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
            'email' => $this->email,
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'country' => $this->country,
            'place' => $this->place,
            'street' => $this->street,
            'address' => $this->address,
            'status' => $this->status,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ];
    }
}
