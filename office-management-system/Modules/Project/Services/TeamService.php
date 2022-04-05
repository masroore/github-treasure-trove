<?php

namespace Modules\Project\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Project\Jobs\SendProjectInviteMailJob;
use Modules\Project\Jobs\SendTeamInviteMailJob;
use Modules\Project\Repositories\ProjectRepository;
use Modules\Project\Repositories\TeamRepository;
use Modules\Project\Repositories\UserRepository;

class TeamService
{
    public $repo;

    public $user;

    public $project;

    public function __construct(TeamRepository $repo, UserRepository $user, ProjectRepository $project)
    {
        $this->repo = $repo;
        $this->user = $user;
        $this->project = $project;
    }

    public function store($params)
    {
        $members = $this->getMemberUserId(explode(',', gv($params, 'members')));
        $team = $this->repo->create($this->formatParams($params));
        $team->users()->attach($members);

        foreach ($team->users as $key => $user) {
            dispatch(new SendTeamInviteMailJob($user, $team, Auth::user()));
        }

        return $team;
    }

    protected function formatParams($params, $model_id = null): array
    {
        if (gv($params, 'type') && gv($params, 'type') == 'description') {
            return [
                'description' => gv($params, 'description'),
            ];
        }

        return [
            'name' => gv($params, 'name'),
            'uuid' => uniqid('team-'),
            'description' => gv($params, 'description'),
            'user_id' => Auth::id(),
            'workspace_id' => Auth::user()->current_workspace_id,
            'privacy_type' => gv($params, 'privacy_type', 0),
        ];
    }

    public function update($params, $id)
    {
        $model = $this->findOrFail($id);

        return $this->repo->update($model, $this->formatParams($params, $model->id));
    }

    public function getMemberUserId($data): array
    {
        return $this->user->getUserIdByEmail($data);
    }

    public function getUserSuggestion($data)
    {
        return $this->user->getUserSuggestion($data);
    }

    public function findOrFail($id)
    {
        return $this->repo->findOrFail($id);
    }

    public function show($id)
    {
        $model = $this->findOrFail($id);
        if ($model->users->contains(Auth::id()) || $model->user_id == Auth::id()) {
            return $model;
        }

        return abort(403, __('project::team.unauthorized'));
    }

    public function inviteMemberToTeam($data)
    {
        $members = $this->getMemberUserId(explode(',', gv($data, 'members'))); //[1, 4, 6]

        $membersForProject = $members;

        $team = $this->findOrFail($data['team_id']);

        $existMembsers = []; //[1, 3, 4];
        foreach ($team->users as $user) {
            $existMembsers[] = $user->id;
        }

        foreach ($members as $key => $value) {
            if (in_array($value, $existMembsers)) {
                unset($members[$key]);
            }
        }
        if (count($members) > 0) {
            $team->users()->attach($members);

            $newUsers = $this->user->getUsersByMultipuleId($members);
            foreach ($newUsers as $key => $user) {
                dispatch(new SendTeamInviteMailJob($user, $team, Auth::user()));
            }
        }

        if ($data['project_id'] != null) {
            $this->inviteMemberToProject($data['project_id'], $membersForProject);
        }

        return $team;
    }

    public function inviteMemberToProject($project_id, $members)
    {
        $project = $this->project->find($project_id);

        if ($project) {
            $existMembsers = []; //[1, 3, 4];
            foreach ($project->users as $user) {
                $existMembsers[] = $user->id;
            }

            foreach ($members as $key => $value) {
                if (in_array($value, $existMembsers)) {
                    unset($members[$key]);
                }
            }
            $project->users()->attach($members);

            $newUsers = $this->user->getUsersByMultipuleId($members);
            foreach ($newUsers as $key => $user) {
                dispatch(new SendProjectInviteMailJob($user, $project, Auth::user()));
            }

            return $project;
        }

        return 0;
    }

    public function invitePreRequisite($team_id)
    {
        $team = $this->findOrFail($team_id);
        $projects = $team->projects()->pluck('name', 'id');

        return compact('team', 'projects');
    }

    public function teamListByCurrentUserWorkspace()
    {
        $workspace_id = Auth::user()->current_workspace_id;

        return $this->repo->teamByWorkspace($workspace_id);
    }

    public function teamUsers($id)
    {
        return $this->repo->teamUsers2($id);
    }
}
