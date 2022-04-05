<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favorite in the database.
     */
    public function store(Reply $reply): void
    {
        $reply->favorite();

        $reply->owner->gainReputation('reply_favorited');
    }

    /**
     * Delete the favorite.
     */
    public function destroy(Reply $reply): void
    {
        $reply->unfavorite();

        $reply->owner->loseReputation('reply_favorited');
    }
}
