<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'project_id' => $this->project_id,
            'uuid' => $this->uuid,
            'section_id' => $this->section_id,
            'completed' => $this->completed,
            'created_at' => $this->created_at,
            'likes' => $this->likes->count(),
            'user_like' => $this->likes()->where('user_id', auth()->user() ? auth()->user()->id : 'tariq')->exists(),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'comment_count' => $this->comments->whereNull('event')->count() + $this->comments->Where('event', 'attached')->count(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'pined_comments' => CommentResource::collection($this->whenLoaded('pined_comments')),
            'fields' => TaskFieldResource::collection($this->whenLoaded('fields')),
            'all_fields' => TaskFieldResource::collection($this->whenLoaded('all_fields')),
            'tasks' => self::collection($this->whenLoaded('tasks')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'project' => new ProjectResource($this->whenLoaded('project')),

        ];
    }
}
