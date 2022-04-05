<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Lock the given thread.
     */
    public function store(Thread $thread): void
    {
        $thread->update(['locked' => true]);
    }

    /**
     * Unlock the given thread.
     */
    public function destroy(Thread $thread): void
    {
        $thread->update(['locked' => false]);
    }
}
