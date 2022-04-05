<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hifone\Providers;

use Hifone\Models\Ad\Adspace;
use Hifone\Models\Node;
use Hifone\Models\Reply;
use Hifone\Models\Section;
use Hifone\Models\Tag;
use Hifone\Models\Thread;
use Hifone\Models\Tip;
use Hifone\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Hifone\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(Router $router): void
    {

        parent::boot($router);

        $this->registerBindings();
    }

    /**
     * Register model bindings.
     */
    protected function registerBindings(): void
    {
        $this->app->router->model('section', Section::class);
        $this->app->router->model('adspace', Adspace::class);
        $this->app->router->model('user', User::class);

        $this->app->router->model('node', Node::class);
        $this->app->router->model('tip', Tip::class);
        $this->app->router->model('thread', Thread::class);
        $this->app->router->model('reply', Reply::class);

        $this->app->router->model('tag', Tag::class, function ($name) {
            return Tag::where('name', urldecode($name))->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     */
    public function map(Router $router): void
    {
        $router->group(['namespace' => $this->namespace], function (Router $router): void {
            foreach (glob(app_path('Http//Routes') . '/*.php') as $file) {
                $this->app->make('Hifone\\Http\\Routes\\' . basename($file, '.php'))->map($router);
            }
        });
    }
}
