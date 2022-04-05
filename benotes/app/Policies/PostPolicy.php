<?php

namespace App\Policies;

use App\Post;
use App\Share;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  mixed      $user
     *
     * @return mixed
     */
    public function view($user, Post $post)
    {
        if ($user instanceof User) {
            return $user->id === $post->user_id;
        } elseif ($user instanceof Share) {
            return $user->collection_id === $post->collection_id;
        }
    }

    /**
     * Determine whether the user can update the post.
     *
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
