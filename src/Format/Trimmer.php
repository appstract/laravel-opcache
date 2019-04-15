<?php

namespace Appstract\Opcache\Format;

/**
 * Interface Trimmer
 */
interface Trimmer
{
    /**
     * Trims the common prefix from an array of strings
     *
     * @param array $scripts The list of scripts
     *
     * @return array The trimmed strings
     */
    public function trim(array $scripts);
}
