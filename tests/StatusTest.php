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

        $this->assertContains('General', $output);
        $this->assertContains('Memory usage', $output);
        $this->assertContains('Interned strings usage', $output);
        $this->assertContains('Statistics', $output);
    }
}
