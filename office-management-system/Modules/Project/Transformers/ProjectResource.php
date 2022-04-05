<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'due_date' => $this->due_date,
            'description' => $this->description,
            'team_id' => $this->team_id,
            'user_id' => $this->user_id,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'team' => new TeamResource($this->whenLoaded('team')),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'fields' => ProjectFieldResource::collection($this->whenLoaded('fields')),
            'visible_fields' => ProjectFieldResource::collection($this->whenLoaded('visible_fields')),
            'comments' => ProjectCommentResource::collection($this->whenLoaded('comments')),

        ];
    }
}
