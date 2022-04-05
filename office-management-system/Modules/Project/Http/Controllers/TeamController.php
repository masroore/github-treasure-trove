<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Project\Http\Requests\TeamRequest;
use Modules\Project\Services\TeamService;

class TeamController extends Controller
{
    public $service;

    public $request;

    public function __construct(
        TeamService $service,
        Request $request
    ) {
        $this->service = $service;
        $this->request = $request;
    }

    public function create()
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        return view('project::team.create');
    }

    public function store(TeamRequest $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }
        $model = $this->service->store($request->all());

        return $this->success([
            'message' => __('project::team.create_successfully'),
            'model' => $model,
            'reload' => true,
        ]);
    }

    public function update(TeamRequest $request, $id)
    {
        $this->service->update($request->all(), $id);

        return $this->success([
            'message' => __('project::team.edited_successfully'),
        ]);
    }

    public function show($id)
    {
        $model = $this->service->show($id);

        return view('project::team.show', compact('model'));
    }

    public function inviteFormCreate($id)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        $preRequisite = $this->service->invitePreRequisite($id);

        return view('project::invite-people.invite', $preRequisite);
    }

    public function teamInviteStore(Request $request)
    {
        if (!$this->request->ajax()) {
            abort(404);
        }

        $this->service->inviteMemberToTeam($request);

        return $this->success([
            'message' => __('project::team.member_invited'),
            'reload' => true,
        ]);
    }

    public function teamUsers($id)
    {
        return $this->service->teamUsers($id);
    }
}
