<?php

namespace Appstract\Opcache;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
                Commands\Optimize::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // bind facade
        $this->app->bind('OPcache', function() {
            return new OpcacheClass();
        });

        // bind routes
        Route::group([
            'middleware'    => ['bindings', \Appstract\Opcache\Http\Middleware\Request::class],
            'prefix'        => 'opcache-api',
            'namespace'     => 'Appstract\Opcache\Http\Controllers',
        ], function () {
            require __DIR__.'/Http/routes.php';
        });

        //$this->mergeConfigFrom(__DIR__.'/../config/config.php', 'skeleton');
    }
}
