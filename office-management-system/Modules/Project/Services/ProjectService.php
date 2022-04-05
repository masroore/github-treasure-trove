<?php

namespace Modules\Project\Services;

use Auth;
use Modules\Project\Entities\Upload\Upload;
use Modules\Project\Jobs\SendProjectInviteMailJob;
use Modules\Project\Repositories\FieldRepository;
use Modules\Project\Repositories\ProjectCommentRepository;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Repositories\TaskRepository;
use Modules\Project\Repositories\UserRepository;
use Modules\Project\Transformers\ProjectResource;
use Modules\Project\Transformers\UploadResource;

class ProjectService
{
    public $repo;

    public $user;

    public $field;

    public $task;

    public $comment;

    public function __construct(
        ProjectRepository $repo,
        UserRepository $user,
        FieldRepository $field,
        TaskRepository $task,
        ProjectCommentRepository $comment
    ) {
        $this->repo = $repo;
        $this->user = $user;
        $this->field = $field;
        $this->task = $task;
        $this->comment = $comment;
    }

    public function storeProject($data)
    {
        $model = $this->repo->store($this->formatParams($data));
        $model->users()->attach($model->user_id, ['icon' => 'ti-menu-alt', 'color' => '6457f9', 'default_view' => $model->default_view]);
        $default_fields = $this->field->getByParam(['default' => 1]);

        foreach ($default_fields as $key => $field) {
            $model->fields()->attach($field->id, ['order' => $key]);
        }

        return $model;
    }

    protected function formatParams($params, $model_id = null): array
    {
        return [
            'name' => gv($params, 'name'),
            'uuid' => uniqid('pro-'),
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'team_id' => gv($params, 'team_id'),
            'description' => gv($params, 'description'),
            'privacy' => gv($params, 'privacy'),
            'default_view' => gv($params, 'default_view'),
        ];
    }

    public function findByUuid($uuid)
    {
        return $this->repo->findByUuid($uuid, $with = ['fields', 'users']);
    }

    public function setFieldVisibility(array $request): void
    {
        $project_id = gv($request, 'project_id');
        $field_id = gv($request, 'field_id');
        $project = $this->repo->getByParam(['id' => $project_id], ['fields']);
        foreach ($project->fields as $field) {
            if ($field->id == $field_id) {
                $field->pivot->visibility = !$field->pivot->visibility;
                $field->pivot->save();
            }
        }
    }

    public function shareProject($members, $project_id)
    {
        $users = $this->getUserByEmail($members);
        $project = $this->repo->find($project_id);

        foreach ($users as $key => $user) {
            if (!$project->users()->where('user_id', $user->id)->exists()) {
                $project->users()->attach($user->id);
            }
            dispatch(new SendProjectInviteMailJob($user, $project, Auth::user()));
        }

        return new ProjectResource($this->repo->find($project_id));
    }

    public function getUserByEmail($data)
    {
        return $this->user->getUserByEmail($data);
    }

    public function removeUser($project_id, $user_id)
    {
        $project = $this->repo->find($project_id);

        return $project->users()->detach($user_id);
    }

    public function projectUser($id)
    {
        $project = $this->repo->find($id);

        return $project->users;
    }

    public function updateProjectElement($id, $value, $element)
    {
        $project = $this->repo->find($id);

        foreach ($project->users as $user) {
            if ($user->id == auth()->id()) {
                $user->pivot->$element = $value;
                $user->pivot->save();
            }
        }

        return my_project_configuration($project);
    }

    public function defaultView($request)
    {
        $project_id = gv($request, 'project_id');
        $view = gv($request, 'view', 'list');

        $project = $this->repo->find($project_id);

        return $this->repo->update($project, ['default_view' => $view]);
    }

    public function getImages($request)
    {
        $task_id = $this->task->findByParam(['project_id' => gv($request, 'project_id')])->pluck('id');

        $images = UploadResource::collection(Upload::with('task', 'user')->whereIn('module_id', $task_id)->where('module', 'task')->get());

        return $images;
    }

    public function update($request)
    {
        $project_id = gv($request, 'project_id');
        $project = $this->repo->find($project_id);
        $user_id = gv($request, 'user_id');
        if ($user_id) {
            if (!$project->users()->where('user_id', $user_id)->exists()) {
                $project->users()->attach($user_id);
            }
        }

        return new ProjectResource($this->repo->update($project, [
            'due_date' => gv($request, 'due_date'),
            'user_id' => $user_id,
            'description' => gv($request, 'description'),
            'name' => gv($request, 'name'),
        ]));
    }

    public function delete($request)
    {
        $project_id = gv($request, 'project_id');

        $project = $this->repo->find($project_id);
        $team_id = $project->team_id;
        $this->repo->delete($project);

        return $team_id;
    }

    public function comment($request)
    {
        $project_id = gv($request, 'project_id');
        $parent_id = gv($request, 'parent_id');
        if ($parent_id) {
            $project_id = null;
        }
        $comment = gv($request, 'comment');
        $user_id = Auth::id();
        $this->comment->create([
            'project_id' => $project_id,
            'parent_id' => $parent_id,
            'comment' => $comment,
            'created_by' => $user_id,
        ]);

        return new ProjectResource($this->repo->find(gv($request, 'project_id')));
    }

    public function editComment($request)
    {
        $comment_id = gv($request, 'comment_id');

        $comment = gv($request, 'comment');
        $db_comment = $this->comment->find($comment_id);
        $this->comment->update($db_comment, [
            'comment' => $comment,
        ]);

        return new ProjectResource($this->repo->find(gv($request, 'project_id')));
    }

    public function deleteComment($request)
    {
        $comment_id = gv($request, 'comment_id');
        $db_comment = $this->comment->find($comment_id);
        $this->comment->delete($db_comment);

        return new ProjectResource($this->repo->find(gv($request, 'project_id')));
    }
}
