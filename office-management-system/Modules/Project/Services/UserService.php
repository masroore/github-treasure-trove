<?php

namespace Modules\Project\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Project\Repositories\TeamRepository;
use Modules\Project\Repositories\UserRepository;
use Modules\Project\Repositories\WorkSpaceRepository;
use Modules\Project\Transformers\UserResource;

class UserService
{
    public $repo;

    public $workspace;

    public $team;

    public function __construct(
        UserRepository $repo,
        WorkSpaceRepository $workspace,
        TeamRepository $team
    ) {
        $this->repo = $repo;
        $this->workspace = $workspace;
        $this->team = $team;
    }

    public function removeTeam($team_id)
    {
        $model = $this->team->findOrFail($team_id);

        if ($model->user_id == Auth::id()) {
            $model->delete();
        } else {
            $model->users()->detach(Auth::id());
        }

        return Auth::user()->switchWorkspace($model->workspace);
    }

    public function suggestUserByPriority($data)
    {
        $teamId = $data['team_id'];
        $value = $data['value'];

        $teamUser = $this->getTemaUser($teamId);
        $teamUser = $teamUser->where(function ($query) use ($value): void {
            $query->where('name', 'LIKE', '%' . $value . '%')->orWhere('email', 'LIKE', '%' . $value . '%');
        })->get();

        if (count($teamUser)) {
            return UserResource::collection($teamUser);
        }

        $workspaceId = $this->getWorkSpaceIdByTeam($teamId);

        $teams = $this->team->getTeamByWorkspace($workspaceId);

        $workspaceUser = [];
        foreach ($teams as $team) {
            $users = $team->users()->where(function ($query) use ($value): void {
                $query->where('name', 'LIKE', '%' . $value . '%')->orWhere('email', 'LIKE', '%' . $value . '%');
            })->get();

            foreach ($users as $user) {
                $workspaceUser[$user->id] = $user;
            }
        }
        if (count($workspaceUser)) {
            return UserResource::collection($workspaceUser);
        }

        return UserResource::collection($this->repo->getUserSuggestion($data));
    }

    public function getTemaUser($id)
    {
        return $this->team->teamUsers($id);
    }

    public function getWorkSpaceIdByTeam($id)
    {
        return $this->team->findOrFail($id)->workspace_id;
    }

    public function currentUserFavouriteProject()
    {
        $user = auth()->user();

        return $user->projects()->where('favourite', 1)->get();
    }
}
