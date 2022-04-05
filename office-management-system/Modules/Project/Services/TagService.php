<?php

namespace Modules\Project\Services;

use Modules\Project\Repositories\SectionRepository;
use Modules\Project\Repositories\TagRepository;
use Modules\Project\Repositories\TaskCommentRepository;
use Modules\Project\Repositories\TaskRepository;
use Modules\Project\Transformers\SectionCollection;

class TagService
{
    public $repo;

    public $task;

    public $section;

    public $task_comment;

    public function __construct(
        TagRepository $repo,
        TaskRepository $task,
        SectionRepository $section,
        TaskCommentRepository $task_comment
    ) {
        $this->repo = $repo;
        $this->task = $task;
        $this->section = $section;
        $this->task_comment = $task_comment;
    }

    public function storeTag($name, $taskId, $field_id)
    {
        $data = [
            'name' => $name,
            'user_id' => auth()->id(),
            'workspace_id' => auth()->user()->current_workspace_id,
        ];
        $tag = $this->repo->storeOrGet($data);

        $task = $this->task->findById($taskId);
        $tag_exists = $task->tags()->where('tag_id', $tag->id)->exists();

        if (!$tag_exists) {
            $task->tags()->attach($tag->id);
            $comment_format = [
                'event' => 'added_to',
                'task_id' => $taskId,
                'created_by' => auth()->id(),
            ];

            $comment_format['table_type'] = 'Modules\Project\Entities\Tag';
            $comment_format['new_id'] = $tag->id;
            $this->task_comment->create($comment_format);
            $section = new SectionCollection($this->task->getSectionFromChildTask($task));

            return compact('tag', 'section');
        }
    }

    public function removeTag($task_id, $tag_id): void
    {
        $task = $this->task->findById($task_id);
        $task->tags()->detach($tag_id);
        $comment_format = [
            'event' => 'remove_from',
            'task_id' => $task_id,
            'created_by' => auth()->id(),
        ];

        $comment_format['table_type'] = 'Modules\Project\Entities\Tag';
        $comment_format['old_id'] = $tag_id;
        $this->task_comment->create($comment_format);

    }
}
