<?php

namespace Appstract\Opcache;

use Illuminate\Support\Facades\Route;
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
                Commands\Optimize::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        if (strpos(app()->version(), 'Lumen') === 0) {
            $this->registerLumenRoutes();
        } else {
            $this->registerLaravelRoutes();
        }
    }

    private function registerLumenRoutes()
    {
        // bind lumen routes
        $this->app->group([
            'middleware' => [\Appstract\Opcache\Http\Middleware\Request::class],
            'prefix'     => 'opcache-api',
            'namespace'  => 'Appstract\Opcache\Http\Controllers',
        ], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    private function registerLaravelRoutes()
    {
        // bind routes
        Route::group([
            'middleware' => [\Appstract\Opcache\Http\Middleware\Request::class],
            'prefix'     => 'opcache-api',
            'namespace'  => 'Appstract\Opcache\Http\Controllers',
        ], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }
}
