<?php

namespace Appstract\Opcache;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * Class Helpers
 */
class Helpers
{
    /**
     * Get an active class name.
     *
     * @static
     * @param string $route
     * @param string $class
     * @return string
     */
    public static function active($route, $class = 'lna')
    {
        if (URL::current() === route($route)) {
            return $class;
        }

        return '';
    }

    /**
     * Judging the Lumen environment.
     *
     * @static
     * @return bool
     */
    public static function isLumen()
    {
        return Str::contains(app()->version(), 'Lumen');
    }
}
