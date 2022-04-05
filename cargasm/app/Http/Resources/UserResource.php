<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'nickname' => $this->nickname,
            'email' => $this->email,
            'phone' => $this->phone,
            'about' => $this->about,
            'social' => $this->social,
            'address' => $this->address,
            'settings' => $this->settings,
            'notice' => $this->notice,
            'privacy' => $this->privacy,
            'role' => $this->role,
            'active' => $this->active,
            'domain' => $this->domain,
            'main_photo' => $this->getAllConversions(),
            'phones' => PhoneResource::collection($this->phones),
            'subscriptions' => $this->subscriptions->count(),
            'subscribers' => $this->subscribers->count(),
            //            'cars' => CarForUserResource::collection($this->whenLoaded('cars', $this->cars->where('status',Car::STATUS_PUBLISHED)))
            'cars' => CarForUserResource::collection($this->whenLoaded('cars')),
        ];
    }
}
