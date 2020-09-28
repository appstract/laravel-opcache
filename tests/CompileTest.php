<?php

namespace Appstract\Opcache\Test;

use Artisan;

class CompileTest extends TestCase
{
    /** @test */
    public function optimizes()
    {
        Artisan::call('opcache:compile --force', []);

        $output = Artisan::output();

        $this->assertStringContainsString('files compiled', $output);
    }
}
