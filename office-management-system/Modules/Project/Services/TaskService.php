<?php

namespace Modules\Project\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Project\Entities\Upload\Upload;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Repositories\SectionRepository;
use Modules\Project\Repositories\TaskCommentRepository;
use Modules\Project\Repositories\TaskRepository;
use Modules\Project\Transformers\CommentResource;
use Modules\Project\Transformers\SectionCollection;
use Modules\Project\Transformers\TaskResource;

class TaskService
{
    public $repo;

    public $project;

    public $section;

    public $task_comment;

    public function __construct(
        TaskRepository $repo,
        ProjectRepository $project,
        SectionRepository $section,
        TaskCommentRepository $task_comment
    ) {
        $this->repo = $repo;
        $this->project = $project;
        $this->section = $section;
        $this->task_comment = $task_comment;
    }

    protected function formatParams($params, $model_id = null): array
    {
        return [
            'section_id' => gv($params, 'section_id'),
            'project_id' => gv($params, 'project_id'),
            'parent_id' => gv($params, 'parent_id'),
            'order' => gv($params, 'order', 0),
            'uuid' => uniqid('task-'),
            'created_by' => Auth::id(),
        ];
    }

    public function update($params, $id)
    {
        $model = $this->repo->find($id);

        return new TaskResource($this->repo->update($model, $this->formatParams($params, $model->id)));
    }

    public function updateName($request)
    {
        $task = $this->repo->find(gv($request, 'task_id'));
        if (!$task) {
            return;
        }

        if (!gv($request, 'name')) {
            $this->repo->delete($task);

            return ['deleted' => true];
        }

        $comment_format = [
            'event' => 'changed_name',
            'task_id' => $task->id,
            'created_by' => auth()->id(),
        ];
        $comment_format['old_value'] = $task->name;
        $comment_format['comment'] = gv($request, 'name');
        $this->task_comment->create($comment_format);

        $params = ['name' => gv($request, 'name')];

        return new TaskResource($this->repo->update($task, $params));
    }

    public function create($params)
    {
        $where = [];

        if (gv($params, 'section_id')) {
            $where['section_id'] = $params['section_id'];
        }
        if (gv($params, 'project_id')) {
            $where['project_id'] = $params['project_id'];
        }
        if (gv($params, 'parent_id')) {
            $where['parent_id'] = $params['parent_id'];
        }

        $add_to = gv($params, 'add_to');
        if ($add_to == 'prepend') {
            $tasks = $this->repo->getByParam($where);
            foreach ($tasks as $t) {
                $t->order = $t->order + 1;
                $t->save();
            }
            $params['order'] = 0;
        } elseif ($add_to == 'append') {
            $tasks = $this->repo->getByParam($where)->count();
            $params['order'] = $tasks;
        } else {
            $tasks = $this->repo->model->where($where)->where('order', '>=', $add_to)->get();
            foreach ($tasks as $t) {
                $t->order = $t->order + 1;
                $t->save();
            }
            $params['order'] = $add_to;
        }

        $task = $this->repo->create($this->formatParams($params));

        $project = $this->project->getByParam(['id' => $task->project_id], ['fields']);

        foreach ($project->fields as $field) {
            $task->fields()->attach($field->id);
        }

        $task = $this->repo->findById($task->id, ['fields', 'tasks', 'comments']);

        return new TaskResource($task);
    }

    public function updateField(array $request)
    {
        $task_id = gv($request, 'task_id');
        $field_id = gv($request, 'field_id');
        $task = $this->repo->findById($task_id, ['fields']);

        foreach ($task->fields as $field) {
            if ($field->id == $field_id) {
                if ($field->type == 'user_id' && ($field->pivot->user_id != gv($request, 'user_id'))) {
                    $comment_format = [
                        'event' => 'assigned_to',
                        'task_id' => $task_id,
                        'field_id' => $field_id,
                        'created_by' => auth()->id(),
                    ];

                    if (!gv($request, 'user_id')) {
                        $comment_format['event'] = 'remove_from';
                    }
                    $comment_format['old_id'] = $field->pivot->user_id;
                    $comment_format['table_type'] = 'App\User';
                    $comment_format['new_id'] = gv($request, 'user_id');
                    $this->task_comment->create($comment_format);
                } elseif ($field->type == 'dropdown' && $field->pivot->option_id != gv($request, 'option_id')) {
                    $comment_format = [
                        'event' => 'changed_to',
                        'task_id' => $task_id,
                        'field_id' => $field_id,
                        'created_by' => auth()->id(),
                    ];
                    $comment_format['old_id'] = $field->pivot->option_id;
                    $comment_format['table_type'] = 'Modules\Project\Entities\FieldOption';
                    $comment_format['new_id'] = gv($request, 'option_id');
                    $this->task_comment->create($comment_format);
                } elseif ($field->type == 'date') {
                    $comment_format = [
                        'event' => 'update_field',
                        'task_id' => $task_id,
                        'field_id' => $field_id,
                        'created_by' => auth()->id(),
                    ];
                    $comment_format['old_value'] = $field->pivot->date;
                    $comment_format['comment'] = gv($request, 'date');
                    $this->task_comment->create($comment_format);
                } elseif ($field->type == 'number') {
                    $comment_format = [
                        'event' => 'update_field',
                        'task_id' => $task_id,
                        'field_id' => $field_id,
                        'created_by' => auth()->id(),
                    ];
                    $comment_format['old_value'] = $field->pivot->number;
                    $comment_format['comment'] = gv($request, 'number');
                    $this->task_comment->create($comment_format);
                } elseif ($field->type == 'text') {
                    $comment_format = [
                        'event' => 'update_field',
                        'task_id' => $task_id,
                        'field_id' => $field_id,
                        'created_by' => auth()->id(),
                    ];
                    $comment_format['old_value'] = $field->pivot->text;
                    $comment_format['comment'] = gv($request, 'text');
                    $this->task_comment->create($comment_format);
                }

                $field->pivot->user_id = gv($request, 'user_id');
                $field->pivot->date = gv($request, 'date');
                $field->pivot->option_id = gv($request, 'option_id');
                $field->pivot->number = gv($request, 'number');
                $field->pivot->text = gv($request, 'text');
                $field->pivot->save();
            }
        }

        return new SectionCollection($this->repo->getSectionFromChildTask($task->refresh()));
    }

    public function updateTaskCompleteStatus($task_id, $value)
    {
        $task = $this->repo->findById($task_id);

        $task->completed = $value;
        if ($value) {
            $task->completed_at = Carbon::now();
            $comment_format = [
                'event' => 'completed',
                'task_id' => $task->id,
                'created_by' => auth()->id(),
            ];
            $this->task_comment->create($comment_format);
        } else {
            $task->completed_at = null;
            $comment_format = [
                'event' => 'incompleted',
                'task_id' => $task->id,
                'created_by' => auth()->id(),
            ];
            $this->task_comment->create($comment_format);
        }
        $task->save();

        return new TaskResource($task->refresh());
    }

    public function updateTaskComment($request)
    {
        $task_id = gv($request, 'task_id');
        $comment = gv($request, 'comment');

        $comment_format = [
            'event' => null,
            'task_id' => $task_id,
            'created_by' => auth()->id(),
            'comment' => $comment,
        ];
        $comment = $this->task_comment->create($comment_format);

        return new CommentResource($this->task_comment->find($comment->id));
    }

    public function taskDelete($request)
    {
        $task = $this->repo->findById(gv($request, 'task_id'));

        return $this->repo->delete($task);
    }

    public function show($uuid)
    {
        return new TaskResource($this->repo->findByParam(['uuid' => $uuid], ['tags', 'project', 'fields', 'tasks']));
    }

    public function like($request)
    {
        $task_id = gv($request, 'task_id');
        $value = gbv($request, 'value');
        $task = $this->repo->findById($task_id);

        if ($value) {
            $task->likes()->attach(auth()->user()->id);
        } else {
            $task->likes()->detach(auth()->user()->id);
        }

        $user_like = $task->likes()->where('user_id', auth()->user()->id)->exists();
        $count = $task->likes()->count();

        return compact('user_like', 'count');
    }

    public function checkLike($request)
    {
        $task_id = gv($request, 'task_id');
        $task = $this->repo->findById($task_id);
        if (!$task) {
            $user_like = false;

            $count = 0;
        } else {
            $user_like = $task->likes()->where('user_id', auth()->user()->id)->exists();

            $count = $task->likes()->count();
        }
        $user_like = $task->likes()->where('user_id', auth()->user()->id)->exists();
        $count = $task->likes()->count();

        return compact('user_like', 'count');
    }

    public function commentPinToTop($request)
    {
        $comment_id = gv($request, 'comment_id');

        $comment = $this->task_comment->find($comment_id);

        $this->task_comment->update($comment, [
            'pin_top' => gbv($request, 'pin'),
        ]);

        $task = $this->repo->find($comment->task_id);

        return ['comments' => CommentResource::collection($task->comments), 'pined_comments' => CommentResource::collection($task->pined_comments)];
    }

    public function commentDelete($request)
    {
        $comment_id = gv($request, 'comment_id');

        $comment = $this->task_comment->find($comment_id);

        if ($comment->event == 'attached') {
            $upload_id = $comment->new_id;
            $upload = Upload::find($upload_id);
            $upload->delete();
        }
        $task = $this->repo->find($comment->task_id);
        $this->task_comment->delete($comment);

        $task = $this->repo->find($comment->task_id);

        return ['comments' => CommentResource::collection($task->comments), 'pined_comments' => CommentResource::collection($task->pined_comments)];
    }
}
