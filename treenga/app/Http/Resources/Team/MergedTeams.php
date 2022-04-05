<?php

namespace App\Http\Resources\Team;

use App\Http\Resources\CustomData;
use Illuminate\Http\Resources\Json\JsonResource;

class MergedTeams extends JsonResource
{
    use CustomData;

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
            'userteams' => ShortWithCount::collection($this->userteams),
            'shared' => ShortWithCount::collection($this->shared),
        ];
    }
}
