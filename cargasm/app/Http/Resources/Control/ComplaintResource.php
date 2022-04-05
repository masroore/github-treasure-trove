<?php

namespace App\Http\Resources\Control;

use App\Http\Resources\AuthorResource;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
//    protected $type;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $type = '';
        switch (true) {
            case $this->complaintable instanceof Post:
                $type = 'post';

                break;
            case $this->complaintable instanceof Event:
                $type = 'event';

                break;
            case $this->complaintable instanceof Photo:
                $type = 'photo';

                break;
            case $this->complaintable instanceof User:
                $type = 'user';

                break;
            case $this->complaintable instanceof Service:
                $type = 'service';

                break;
        }

        return [
            'entity' => $type,
            'id' => optional($this->complaintable)->id,
            'title' => optional($this->complaintable)->title,
            'complaint_text' => $this->complaint_text,
            'theme' => $this->theme,
            'complaint_user' => AuthorResource::make($this->user),
        ];
    }
}
