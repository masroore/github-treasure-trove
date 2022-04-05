<?php

namespace App\Http\Controllers;

use App\Thread;

class PinnedThreadsController extends Controller
{
    /**
     * Pin the given thread.
     */
    public function store(Thread $thread): void
    {
        $thread->update(['pinned' => true]);
    }

    /**
     * Un-Pin the given thread.
     */
    public function destroy(Thread $thread): void
    {
        $thread->update(['pinned' => false]);
    }
}
