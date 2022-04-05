<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'surname' => $this->surname,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'inn' => $this->inn,
            'scan' => $this->scan,
            'birthday' => $this->birthday,
            'dismissed' => $this->dismissed,
        ];
    }
}
