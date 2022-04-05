<?php

namespace App\Providers;

use App\Services\UrlGenerator;
use Illuminate\Routing\RoutingServiceProvider as BaseRoutingServiceProvider;

class TrailingSlashRoutingServiceProvider extends BaseRoutingServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerUrlGenerator();
    }

    protected function registerUrlGenerator(): void
    {
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();

            // The URL generator needs the route collection that exists on the router.
            // Keep in mind this is an object, so we're passing by references here
            // and all the registered routes will be available to the generator.
            $app->instance('routes', $routes);

            $url = new UrlGenerator(
                $routes,
                $app->rebinding(
                    'request',
                    $this->requestRebinder()
                )
            );

            // Next we will set a few service resolvers on the URL generator so it can
            // get the information it needs to function. This just provides some of
            // the convenience features to this URL generator like "signed" URLs.
            $url->setSessionResolver(function () use ($app) {
                return $app['session'];
            });

            $url->setKeyResolver(function () use ($app) {
                return $app->make('config')->get('app.key');
            });

            // If the route collection is "rebound", for example, when the routes stay
            // cached for the application, we will need to rebind the routes on the
            // URL generator instance so it has the latest version of the routes.
            $app->rebinding('routes', function ($app, $routes): void {
                $app['url']->setRoutes($routes);
            });

            return $url;
        });
    }
}
