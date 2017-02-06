<?php

namespace Appstract\Opcache\Test;

use Artisan;

class ConfigTest extends TestCase
{
    /** @test */
    public function shows_config()
    {
        Artisan::call('opcache:config', []);

        $output = Artisan::output();

        $this->assertContains('Version info', $output);
        $this->assertContains('Configuration info', $output);
    }
}
