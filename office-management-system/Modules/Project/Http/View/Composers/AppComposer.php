<?php

namespace Modules\Project\Http\View\Composers;

use Illuminate\View\View;
use Modules\Project\Services\UserService;
use Modules\Project\Services\WorkSpaceService;

class AppComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $workspace;

    protected $user;

    /**
     * Create a new profile composer.
     */
    public function __construct(WorkSpaceService $workspace, UserService $user)
    {
        $this->workspace = $workspace;
        $this->user = $user;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('global_workspaces', $this->workspace->getUserWorkspace());
        $view->with('global_teams', $this->workspace->currentWorkspaceTeams());
        $view->with('user_favourite', $this->user->currentUserFavouriteProject());
    }
}
