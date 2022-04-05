<?php

namespace App\Services;

use App\Category;
use App\Task;
use App\Team;
use App\User;

class CoreService
{
    protected function throwUserLock(User $user)
    {
        return true;
    }

    protected function throwUserCantCreate(User $user): void
    {
        customThrowIf(!$user->is_team_author, 'Not allowed to create teams');
    }

    protected function throwUserTeam(User $user, Team $team): void
    {
        $user->loadMissing('teams');
        $teams = $user->all_teams;

        customThrowIf(!$teams->contains('id', $team->id), 'Wrong team');
    }

    protected function throwCategoryTeam(Category $category, Team $team): void
    {
        $team->loadMissing(['categories' => function ($q): void {
            $q->withTrashed();
        }]);

        customThrowIf(!$team->categories->contains('id', $category->id), 'Category not in team');
    }

    protected function throwNotUserCategory(User $user, Category $category): void
    {
        $user->loadMissing('categories');
        customThrowIf(!$user->categories->contains('id', $category->id), 'Wrong Category');
    }

    protected function throwTeamHasUsersIds(Team $team, array $userIds): void
    {
        $team->loadMissing('users');
        $teamUsersIds = $team->users->pluck('id')->values()->toArray();
        $contains = count(array_intersect($userIds, $teamUsersIds)) == count($userIds);

        customThrowIf(!$contains, 'Wrong users');
    }

    protected function throwTeamHasCats(Team $team, array $catIds): void
    {
        $team->loadMissing('categories');
        $teamCatsIds = $team->categories->pluck('id')->values()->toArray();

        $contains = count(array_intersect($catIds, $teamCatsIds)) == count($catIds);

        customThrowIf(!$contains, 'Wrong categories');
    }

    protected function throwTaskTeam(Task $task, Team $team): void
    {
        customThrowIf($task->team_id != $team->id, 'Task not in team');
    }

    protected function throwTeamHasTasks(Team $team, array $taskIds, $withTrashed = false): void
    {
        $team->loadMissing(['tasks' => function ($q) use ($withTrashed): void {
            $withTrashed ? $q->withTrashed() : false;
        }]);
        $teamTasksIds = $team->tasks->pluck('id')->values()->toArray();

        $contains = count(array_intersect($taskIds, $teamTasksIds)) == count($taskIds);

        customThrowIf(!$contains, 'Wrong tasks');
    }

    protected function throwNotUserTask(User $user, Task $task): void
    {
        customThrowIf($task->isDraft() && !$task->isUserDraft($user), 'It\'s not your draft');
        customThrowIf($task->isPrivate() && !$task->isAutored($user), 'It\'s not your task');
    }

    protected function getSearchParam()
    {
        $search = request()->get('search', null);
        customThrowIf($search && strlen($search) > 256, 'Too long search input');

        return $search;
    }
}
