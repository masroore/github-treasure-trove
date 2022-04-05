<?php

namespace Modules\Project\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Project\Http\View\Composers\AppComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function boot(): void
    {
        View::composer('backEnd.master', AppComposer::class);
        View::composer('layouts.app_vue', AppComposer::class);
        View::composer('layouts.app_task', AppComposer::class);
    }
}
