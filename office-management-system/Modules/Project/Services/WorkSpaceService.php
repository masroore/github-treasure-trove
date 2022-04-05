<?php

namespace Modules\Project\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Project\Jobs\SendTeamInviteMailJob;
use Modules\Project\Repositories\TeamRepository;
use Modules\Project\Repositories\UserRepository;
use Modules\Project\Repositories\WorkSpaceRepository;
use Modules\Project\Transformers\UserResource;

class WorkSpaceService
{
    public $repo;

    public $user;

    public $team;

    public function __construct(
        WorkSpaceRepository $repo,
        UserRepository $user,
        TeamRepository $team
    )
    {
        $this->repo = $repo;
        $this->user = $user;
        $this->team = $team;
    }

    public function store($params)
    {
        $members = $this->getMemberUserId(explode(',', gv($params, 'members')));
        $workspace = $this->repo->create($this->formatParams($params));
        $teamAttribute = [
            'name' => $workspace->name,
            'user_id' => Auth::id(),
            'workspace_id' => $workspace->id,
        ];
        $team = $this->team->create($teamAttribute);

        $result = $team->users()->attach($members);
        // update current user workspace
        Auth::user()->switchWorkspace($workspace);

        foreach ($team->users as $key => $user) {
            dispatch(new SendTeamInviteMailJob($user, $team, Auth::user()));
        }

        return $result;
    }

    public function getMemberUserId($params): array
    {
        return UserResource::collection($this->user->getUserIdByEmail($params));
    }

    protected function formatParams($params, $model_id = null): array
    {
        return [
            'name' => gv($params, 'name'),
            'user_id' => Auth::id(),
            'default_workspace' => false,
        ];
    }

    public function getUserSuggestion($params)
    {
        return UserResource::collection($this->user->getUserSuggestion($params));
    }

    public function currentWorkSpaceMembers($data)
    {
        return UserResource::collection($this->repo->currentWorkSpaceAllMembers($data['value']));
    }

    public function getUserWorkspace()
    {
        return $this->repo->allWorkspace();
    }

    public function currentWorkspaceTeams()
    {
        return $this->repo->allTeamForUserCurrentWorkspace();
    }
}
