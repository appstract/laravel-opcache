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
                Commands\Optimize::class,
            ]);

            if (! str_contains($this->app->version(), 'Lumen')) {
                $this->publishes([
                    __DIR__.'/../config/opcache.php' => config_path('opcache.php'),
                ], 'config');
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // config
        $this->mergeConfigFrom(__DIR__.'/../config/opcache.php', 'opcache');

        if ($this->isLumenWithoutRouterVersion()) {
            $router = $this->app;
        } else {
            $router = $this->app->router;
        }

        // bind routes
        $router->group([
            'middleware'    => [\Appstract\Opcache\Http\Middleware\Request::class],
            'prefix'        => 'opcache-api',
            'namespace'     => 'Appstract\Opcache\Http\Controllers',
        ], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }

    private function isLumenWithoutRouterVersion()
    {
        $version = $this->app->version();
        if (! str_contains($version, 'Lumen')) {
            return false;
        }

        if (preg_match('/.*\((\d+\.\d+\.\d+)\).*/', $version, $m)) {
            return version_compare('5.5', $m[1]) > 0;
        }

        return true;
    }
}
