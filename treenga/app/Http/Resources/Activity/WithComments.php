<?php

namespace App\Http\Resources\Activity;

use App\Activity;
use App\Comment;
use App\Http\Resources\Activity\Short as ActivityShortResourse;
use App\Http\Resources\Comment\TreeForActivities as CommentTreeForActivitiesResourse;
use Illuminate\Http\Resources\Json\JsonResource;

class WithComments extends JsonResource
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
        switch (true) {
            case $this->resource instanceof Comment:
                return new CommentTreeForActivitiesResourse($this->resource);

                break;
            case $this->resource instanceof Activity:
                return new ActivityShortResourse($this->resource);

                break;
        }
    }
}
