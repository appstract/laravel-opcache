<?php

namespace Appstract\Opcache\Test;

use Artisan;

class OptimizeTest extends TestCase
{
    /** @test */
    public function optimizes()
    {
        Artisan::call('opcache:optimize', []);

        $output = Artisan::output();

        $this->assertContains('files optimized', $output);
    }
}
