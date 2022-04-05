<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Http\Requests\TaskRequest;
use Modules\Project\Services\TaskService;
use Modules\Project\Transformers\UserResource;

class TaskController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        TaskService $service,
        Request $request
    ) {
        $this->service = $service;
        $this->request = $request;
    }

    public function store(TaskRequest $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        return $this->service->create($this->request->all());
    }

    public function updateName()
    {
        $request = $this->request->all();

        return $this->service->updateName($request);
    }

    public function updateField()
    {
        $request = $this->request->all();

        return $this->service->updateField($request);
    }

    public function updateTaskUser(Request $request)
    {
        $user_id = $request->user_id;
        $task_id = $request->task_id;
        $field_id = $request->field_id;

        return $this->service->updateTaskUser($task_id, $user_id, $field_id);
    }

    public function taskComplete(Request $request)
    {
        $task_id = $request->task_id;
        $value = $request->value;

        return $this->service->updateTaskCompleteStatus($task_id, $value);
    }

    public function taskComment()
    {
        return $this->service->updateTaskComment($this->request->all());
    }

    public function taskDelete()
    {
        return $this->service->taskDelete($this->request->all());
    }

    public function show($uuid)
    {
        $task = $this->service->show($uuid);
        if ($this->request->ajax()) {
            $auth_user = new UserResource(auth()->user());

            return $this->ok(['task' => $task, 'auth_user' => $auth_user]);
        }

        return view('project::task.show', compact('task'));
    }

    public function taskLike()
    {
        return $this->service->like($this->request->all());
    }

    public function checkTaskLike()
    {
        return $this->service->checkLike($this->request->all());
    }

    public function taskCommentPinToTop()
    {
        return $this->service->commentPinToTop($this->request->all());
    }

    public function taskCommentDelete()
    {
        return $this->service->commentDelete($this->request->all());
    }
}
