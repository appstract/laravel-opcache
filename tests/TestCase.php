<?php

namespace Appstract\Opcache\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Appstract\Opcache\OpcacheServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.url', 'http://laravel.dev/');
    }

    protected function getPackageProviders($app)
    {
        return [
            OpcacheServiceProvider::class,
        ];
    }
}
