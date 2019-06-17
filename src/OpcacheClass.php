<?php

namespace Appstract\Opcache;

use Symfony\Component\Finder\Finder;

/**
 * Class OpcacheClass.
 */
class OpcacheClass
{
    /**
     * OpcacheClass constructor.
     */
    public function __construct()
    {
        // constructor body
    }

    /**
     * Clear the cache.
     *
     * @return bool
     */
    public function clear()
    {
        if (function_exists('opcache_reset')) {
            return opcache_reset();
        }

        return false;
    }

    /**
     * Get configuration values.
     *
     * @return mixed
     */
    public function getConfig()
    {
        if (function_exists('opcache_get_configuration')) {
            $config = opcache_get_configuration();

            return $config ?: false;
        }

        return false;
    }

    /**
     * Get status info.
     *
     * @return mixed
     */
    public function getStatus()
    {
        if (function_exists('opcache_get_status')) {
            $status = opcache_get_status(false);

            return $status ?: false;
        }

        return false;
    }

    /**
     * Precompile app.
     *
     * @return bool | array
     */
    public function optimize()
    {
        if (! function_exists('opcache_compile_file')) {
            return false;
        }

        // Get files in these paths
        $files = Finder::create()->in(config('opcache.directories'))
            ->name('*.php')
            ->files();

        $files = collect($files);

        // optimized files
        $optimized = 0;

        $files->each(function ($file) use (&$optimized) {
            if (!opcache_is_script_cached($file) && @opcache_compile_file($file)) {
                $optimized++;
            }
        });

        return [
            'total_files_count' => $files->count(),
            'compiled_count'    => $optimized,
        ];
    }
}
