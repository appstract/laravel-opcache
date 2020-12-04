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
     */
    public function clear()
    {
        if (function_exists('opcache_reset')) {
            return opcache_reset();
        }
    }

    /**
     * Get configuration values.
     */
    public function getConfig()
    {
        if (function_exists('opcache_get_configuration')) {
            return opcache_get_configuration();
        }
    }

    /**
     * Get status info.
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
     * @param bool $force
     * @return array
     */
    public function compile($force = false)
    {
        if (! ini_get('opcache.dups_fix') && ! $force) {
            return ['message' => 'opcache.dups_fix must be enabled, or run with --force'];
        }

        if (function_exists('opcache_compile_file')) {

            // Get files in these paths
            $files = collect(Finder::create()->in(config('opcache.directories'))
                ->name('*.php')
                ->ignoreUnreadableDirs()
                ->notContains('#!/usr/bin/env php')
                ->exclude(config('opcache.exclude'))
                ->files()
                ->followLinks());

            // optimized files
            $compiled = $files->filter(function ($file) {
                if (opcache_is_script_cached($file)) {
                    return false;
                }
                @opcache_compile_file($file);

                return true;
            });

            return [
                'total_files_count' => $files->count(),
                'compiled_count' => $compiled->count(),
            ];
        }
    }
}
