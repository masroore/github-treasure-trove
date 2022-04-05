<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Response;

class ProfilesController extends Controller
{
    /**
     * Fetch the user's activity feed.
     *
     * @#param User $user
     */
    public function index(User $user)
    {
        return [
            'activities' => Activity::feed($user),
        ];
    }

    /**
     * Show the user's profile.
     *
     * @return Response
     */
    public function show(User $user)
    {
        $data = ['profileUser' => $user];

        if (request()->expectsJson()) {
            return $data;
        }

        return view('profiles.show', $data);
    }
}
