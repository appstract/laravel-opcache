<?php

namespace Appstract\Opcache;

use Symfony\Component\Finder\Finder;

/**
 * Class OpcacheClass.
 */
class OpcacheClass
{

    /**
     * Clear OPcache.
     *
     * @return bool
     */
    public function clear()
    {
        if (function_exists('opcache_reset')) {
            return opcache_reset();
        }
    }

    /**
     * Get configuration values.
     *
     * @return mixed
     */
    public function getConfig()
    {
        if (function_exists('opcache_get_configuration')) {
            return opcache_get_configuration();
        }
    }

    /**
     * Get status info.
     *
     * @return mixed
     */
    public function getStatus()
    {
        if (function_exists('opcache_get_status')) {
            return opcache_get_status(false);
        }
    }

    /**
     * Pre-compile php scripts.
     *
     * @return bool | array
     */
    public function optimize()
    {
        if (function_exists('opcache_compile_file')) {
            $optimized = 0;

            // Get files in these paths
            $files = collect(Finder::create()->in(config('opcache.directories'))
                ->name('*.php')
                ->files());

            // optimized files
            $files->each(function ($file) use (&$optimized) {
                if (@opcache_compile_file($file)) {
                    $optimized++;
                }
            });

            return [
                'total_files_count' => $files->count(),
                'compiled_count' => $optimized,
            ];
        }
    }
}
