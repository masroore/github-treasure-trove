<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Services\ProjectService;
use Modules\Project\Services\TeamService;

class ProjectController extends Controller
{
    public $service;

    public $request;

    public $team;

    public function __construct(
        ProjectService $service,
        Request $request,
        TeamService $team
    ) {
        $this->service = $service;
        $this->request = $request;
        $this->team = $team;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create($teamId = null)
    {
        $team_id = $teamId ?? null;
        $teams = $this->team->teamListByCurrentUserWorkspace()->pluck('name', 'id')->toArray();

        return view('project::project.create', compact('team_id', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \App\Http\Controllers\Response
     */
    public function store(ProjectRequest $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $project = $this->service->storeProject($request);

        return $this->success([
            'message' => trans('project::project.created_successfully'),
            'goto' => route('project.show', $project->uuid),
        ]);
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show($id, $view = null)
    {
        $model = $this->service->findByUuid($id);

        $blade = '';
        if (!$view) {
            $blade = $model->default_view;
        } else {
            if (in_array($view, ['board', 'files', 'conversation'])) {
                $blade = $view;
            }
        }
        if ($blade == 'list') {
            $blade = '';
        }

        return view('project::project.show' . $blade, compact('model', 'blade'));
    }

    public function shareProject(Request $request)
    {
        $request->validate([
            'members' => 'required',
            'project_id' => 'required',
        ]);
        $members = $request->members;
        $project_id = $request->project_id;

        $project = $this->service->shareProject($members, $project_id);

        return response()->json([
            'project' => $project,
            'success' => true,
            'message' => trans('project::project.share_successfull'),
        ]);
    }

    public function removeUser(Request $request)
    {
        $user_id = $request->user_id;
        $project_id = $request->project_id;

        $this->service->removeUser($project_id, $user_id);

        return response()->json([
            'success' => true,
            'message' => trans('project::project.user_removed'),
        ]);
    }

    public function projectUser($id)
    {
        return $this->service->projectUser($id);
    }

    public function updateColor(Request $request)
    {
        $color = $request->color;
        $project_id = $request->project_id;

        return $this->service->updateProjectElement($project_id, $color, 'color');
    }

    public function updateIcon(Request $request)
    {
        $icon = $request->icon;
        $project_id = $request->project_id;

        return $this->service->updateProjectElement($project_id, $icon, 'icon');
    }

    public function updateFavorite(Request $request)
    {
        $fav = $request->favorite;
        $project_id = $request->project_id;

        return $this->service->updateProjectElement($project_id, $fav, 'favourite');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Renderable
     */
    public function update(Request $request)
    {
        return $this->service->update($request->all());
    }

    public function setFieldVisibility(): void
    {
        $this->service->setFieldVisibility($this->request->all());
    }

    public function defaultView()
    {
        return $this->service->defaultView($this->request->all());
    }

    public function getImages()
    {
        return $this->service->getImages($this->request->all());
    }

    public function deleteProject()
    {
        $team_id = $this->service->delete($this->request->all());

        return $this->success([
            'message' => trans('project::project.delete_successfull'),
            'goto' => route('team.show', $team_id),
        ]);
    }

    public function comment()
    {
        $project = $this->service->comment($this->request->all());

        return $this->success([
            'message' => trans('project::project.comment_added_successfull'),
            'project' => $project,
        ]);
    }

    public function editComment()
    {
        $project = $this->service->editComment($this->request->all());

        return $this->success([
            'message' => trans('project::project.comment_edited_successfull'),
            'project' => $project,
        ]);
    }

    public function deleteComment()
    {
        $project = $this->service->deleteComment($this->request->all());

        return $this->success([
            'message' => trans('project::project.comment_deleted_successfull'),
            'project' => $project,
        ]);
    }
}
