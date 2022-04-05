<?php

namespace App\Repositories;

use App\Activity;
use App\Task;

class ActivityRepository
{
    public function createTaskItem(Task $task, array $data)
    {
        return $task->activities()->create($data);
    }

    public function createUnreadActivities(Activity $activity, $subscribers): void
    {
        $activity->unreadUsers()->attach($subscribers);
    }
}
