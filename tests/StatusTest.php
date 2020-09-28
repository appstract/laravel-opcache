<?php

namespace Appstract\Opcache\Test;

use Artisan;

class StatusTest extends TestCase
{
    /** @test */
    public function shows_status()
    {
        Artisan::call('opcache:status', []);

        $output = Artisan::output();

        $this->assertStringContainsString('Memory usage:', $output);
        $this->assertStringContainsString('Interned strings usage:', $output);
        $this->assertStringContainsString('Statistics:', $output);
    }
}
