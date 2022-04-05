<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        return $task->open && $task->section->students->contains($user->student);
    }

    /**
     * Determine whether the user can submit answers to the model.
     *
     * @return mixed
     */
    public function submit(User $user, Task $task)
    {
        if (!$task->deadline) {
            return true;
        }
        if ($task->deadline && $task->deadline > now()) {
            return true;
        }
        $ext = $task->extensions()->where('student_id', $user->student->id)->first();
        if (!$ext) {
            return false;
        }

        return $ext->deadline > now();

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Task $task)
    {

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {

    }
}
