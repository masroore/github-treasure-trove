<?php

namespace App\Listeners;

use App\Notifications\Category\Commented as CategoryCommentedNotify;
use App\Notifications\Category\EditedDesc as CategoryEditedDescNotify;
use App\Notifications\Category\Reverted as CategoryRevertedNotify;
use App\Notifications\Category\Subscribed as CategorySubscribedNotify;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Notification;

class CategorySubscriber
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function onDescCreated($event): void
    {
        $team = $event->team;
        $category = $event->category;
        $me = $event->me;
        if ($category->isPublic()) {
            $resipients = $category->subscribers->except(['id' => $me->id]);
            Notification::send($resipients, new CategorySubscribedNotify($team, $category, $me));
        }
    }

    public function onDescEdited($event): void
    {
        $team = $event->team;
        $category = $event->category;
        $me = $event->me;
        $newSubscribersIds = $event->newSubscribersIds;
        if ($category->isPublic()) {
            if (count($newSubscribersIds)) {
                Notification::send(User::find($newSubscribersIds), new CategorySubscribedNotify($team, $category, $me));
            }
            $resipients = $category->subscribers->except(['id' => $me->id])->except($newSubscribersIds);
            Notification::send($resipients, new CategoryEditedDescNotify($team, $category, $me));
        }
    }

    public function onCommented($event): void
    {
        $team = $event->team;
        $category = $event->category;
        $me = $event->me;
        if ($category->isPublic()) {
            $resipients = $category->subscribers->except(['id' => $me->id]);
            Notification::send($resipients, new CategoryCommentedNotify($team, $category, $me));
        }
    }

    public function onViewed($event): void
    {
        $team = $event->team;
        $category = $event->category;
        $me = $event->me;
        if ($category->isPublic()) {
            $notifications = $this->userRepository->getNotificationByCategory($me, $category);
            $notifications->each(function ($item): void {
                $item->delete();
            });
        }
    }

    public function onReverted($event): void
    {
        $team = $event->team;
        $category = $event->category;
        $me = $event->me;
        if ($category->isPublic()) {
            $resipients = $category->subscribers->except(['id' => $me->id]);
            Notification::send($resipients, new CategoryRevertedNotify($team, $category, $me));
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events): void
    {
        $events->listen(
            'App\Events\Category\DescCreated',
            'App\Listeners\CategorySubscriber@onDescCreated'
        );
        $events->listen(
            'App\Events\Category\DescEdited',
            'App\Listeners\CategorySubscriber@onDescEdited'
        );
        $events->listen(
            'App\Events\Category\Commented',
            'App\Listeners\CategorySubscriber@onCommented'
        );
        $events->listen(
            'App\Events\Category\Viewed',
            'App\Listeners\CategorySubscriber@onViewed'
        );
        $events->listen(
            'App\Events\Category\Reverted',
            'App\Listeners\CategorySubscriber@onReverted'
        );
    }
}
