<?php

namespace Modules\AdminRbac\Providers;

use Illuminate\Support\ServiceProvider;

class RbacAssetsProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            'vendor/twitter/bootstrap/dist' => public_path('vendor/bootstrap'),
        ], 'public');
    }
}
