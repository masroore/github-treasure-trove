<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    /**
     * Store a new thread subscription.
     *
     * @param int    $channelId
     */
    public function store($channelId, Thread $thread): void
    {
        $thread->subscribe();
    }

    /**
     * Delete an existing thread subscription.
     *
     * @param int    $channelId
     */
    public function destroy($channelId, Thread $thread): void
    {
        $thread->unsubscribe();
    }
}
