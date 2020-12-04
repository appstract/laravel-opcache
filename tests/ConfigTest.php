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

        $this->assertStringContainsString('Version info', $output);
        $this->assertStringContainsString('Configuration info', $output);
    }
}
