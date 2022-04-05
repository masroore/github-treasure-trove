<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserForPageResource extends JsonResource
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
            'name' => $this->when($this->getPrivacyValue('fio'), $this->name, ''),
            //            'surname' => $this->when($this->getPrivacyValue('fio'), $this->surname, ''),
            'nickname' => $this->nickname,
            'email' => $this->when($this->getPrivacyValue('email'), $this->email, ''),
            'phone' => $this->when($this->getPrivacyValue('phone'), $this->phone, ''),
            'about' => $this->about,
            'social' => $this->when($this->getPrivacyValue('social'), $this->social, []),
            'settings' => $this->when($this->getSettingValues('settings'), $this->settings, []),
            'address' => $this->when($this->getAddressValues('address'), $this->address, []),
            'role' => $this->role,
            'active' => $this->active,
            'domain' => $this->domain,
            'main_photo' => $this->getAllConversions(),
            'phones' => PhoneResource::collection($this->phones),
            'subscriptions' => $this->subscriptions->count(),
            'subscribers' => $this->subscribers->count(),
            'subscribed' => $this->when(optional(auth()->user())->checkSubscriptionsForUser($this->id), true, false),
            'cars' => CarForUserResource::collection($this->whenLoaded('cars')),
        ];
    }
}
