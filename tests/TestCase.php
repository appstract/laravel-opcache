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
        $app['config']->set('app.key', 'base64:Ed0VpanUWokW8AgY8jRCU8A5Cn3ou+uby8qLCQysUpg=');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [OpcacheServiceProvider::class];
    }
}
