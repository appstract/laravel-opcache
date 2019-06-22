<?php

namespace Appstract\Opcache;

use Illuminate\Support\ServiceProvider;

class OpcacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Clear::class,
                Commands\Config::class,
                Commands\Status::class,
                Commands\Compile::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/opcache.php' => config_path('opcache.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // config
        $this->mergeConfigFrom(__DIR__.'/../config/opcache.php', 'opcache');

        // bind routes
        $this->app->router->group([
            'middleware'    => [\Appstract\Opcache\Http\Middleware\Request::class],
            'prefix'        => config('opcache.prefix'),
            'namespace'     => 'Appstract\Opcache\Http\Controllers',
        ], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }
}
