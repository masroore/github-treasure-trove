<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-rating', function ($user, $rating) {
            return $user->id === $rating->user_id;
        });

        Gate::define('update-comment', function ($user, $comment) {
            return $user->id === $comment->user->id;
        });

        Gate::define('delete-comment', function ($user, $comment) {
            return $user->id === $comment->user->id;
        });

        Gate::define('comment-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        //Post
        Gate::define('update-post', function ($user, $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('delete-post', function ($user, $post) {
            return $user->id === $post->user_id;
        });

        //Photo
        Gate::define('update-photo', function ($user, $photo) {
            return $user->id === $photo->user_id;
        });

        Gate::define('delete-photo', function ($user, $photo) {
            return $user->id === $photo->user_id;
        });

        // Album
        Gate::define('update-album', function ($user, $album) {
            return $user->id === $album->user_id;
        });

        Gate::define('delete-album', function ($user, $album) {
            return $user->id === $album->user_id;
        });

        // Event
        Gate::define('update-event', function ($user, $event) {
            return $user->id === $event->user_id;
        });

        Gate::define('delete-event', function ($user, $event) {
            return $user->id === $event->user_id;
        });

        Gate::define('create-service', function ($user) {
            return $user->role === User::ROLE_PARTNER || User::ROLE_ADMIN;
        });

        Gate::define('update-service', function ($user, $service) {
            return $user->id === $service->user->id;
        });

        Gate::define('car-update', function ($user, $car) {
            return $user->id === $car->user->id;
        });

        Gate::define('car-delete', function ($user, $car) {
            return $user->id === $car->user->id;
        });

        Gate::define('message-update', function ($user, $message) {
            return $user->id === $message->senderData->id;
        });

        Gate::define('message-delete', function ($user, $message) {
            return $user->id === $message->senderData->id;
        });

        Gate::define('service-delete', function ($user, $service) {
            return $user->id === $service->user->id;
        });

        Gate::define('rating-delete', function ($user, $rating) {
            return $user->id === $rating->user->id;
        });

        Gate::define('page-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('handbook-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('banner-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('menu-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('term-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('variable-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('service-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });
        Gate::define('post-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });
        Gate::define('event-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });
        Gate::define('car-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });
        Gate::define('user-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('media-manage', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });
    }
}
