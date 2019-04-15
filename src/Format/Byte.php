<?php

namespace Appstract\Opcache\Format;

/**
 * Class Byte
 */
class Byte
{
    /**
     * Formatter for byte values
     *
     * @category   OpCacheGUI
     * @package    Format
     * @author     Pieter Hordijk <info@pieterhordijk.com>
     */
    public function format($size, $decimals = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $position = 0;

        do {
            if ($size < 1024) {
                return round($size, $decimals) . $units[$position];
            }

            $size = $size / 1024;
            $position++;
        } while ($position < count($units));

        return round($size, $decimals) . end($units);
    }
}
