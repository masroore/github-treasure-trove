<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hifone\Handlers\Listeners\Notification;

use Auth;
use Hifone\Events\Thread\ThreadEventInterface;
use Hifone\Models\Thread;
use Hifone\Models\User;

class SendThreadNotificationHandler
{
    /**
     * Handle the thread.
     */
    public function handle(ThreadEventInterface $event): void
    {
        $this->trigger($event->thread);
    }

    protected function trigger(Thread &$thread): void
    {
        $this->newThreadNotify(Auth::user(), $thread);
    }

    protected function newThreadNotify(User $author, Thread $thread): void
    {
        // Notify followed users
        app('notifier')->batchNotify(
            'followed_user_new_thread',
            $author,
            $author->follows()->get(),
            $thread,
            $thread->body
        );
        // Notify mentioned users
        $parserAt = app('parser.at');
        $parserAt->parse($thread->body_original);

        app('notifier')->batchNotify(
            'thread_mention',
            $author,
            $parserAt->users,
            $thread,
            $thread->body
        );
    }
}
