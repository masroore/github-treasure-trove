<?php

namespace App\Http\Resources\Control;

use App\Http\Resources\PhoneResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
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
            'social' => $this->getSocialValues(),
            'role' => $this->role,
            'status' => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'msg_reject' => $this->msg_reject,
            'phones' => PhoneResource::collection($this->phones),
            'privacy ' => $this->getPrivacyValues(),
            //            'domain' => $this->domain,
            'avatar' => new MediaResource($this->whenLoaded('media', function () {
                return $this->getFirstMedia('avatar');
            })),
        ];
    }
}
