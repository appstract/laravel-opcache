<?php

namespace Appstract\Opcache\Test;

use Appstract\Opcache\OpcacheServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

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
