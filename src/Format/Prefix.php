<?php

namespace Appstract\Opcache\Format;

/**
 * Class Prefix
 */
class Prefix implements Trimmer
{
    /**
     * Trims the common prefix from an array of strings
     *
     * @param array $scripts The list of scripts
     *
     * @return array The trimmed strings
     */
    public function trim(array $scripts)
    {
        $prefix = $this->getPrefix($scripts);
        $length = mb_strlen($prefix);

        foreach ($scripts as $index => $script) {
            $scripts[$index]['prefix'] = $prefix;
            $scripts[$index]['full_path'] = mb_substr($script['full_path'], $length);
        }

        return $scripts;
    }

    /**
     * Gets common prefix to trim
     *
     * @param array $scripts The list of scripts
     *
     * @return string The common prefix
     */
    private function getPrefix(array $scripts)
    {
        $prefix = $scripts[0]['full_path'];

        foreach ($scripts as $script) {
            if ($prefix === '') {
                return 0;
            }

            if (strpos($script['full_path'], $prefix) === 0) {
                continue;
            }

            $prefix = $this->findLongestPrefix($prefix, $script['full_path']);

        }

        return $prefix;
    }

    /**
     * Get the longest common prefix between two strings
     *
     * @param string $prefix The current common prefix
     * @param string $path   The path to match against the common prefix
     *
     * @return string The common prefix
     */
    private function findLongestPrefix($prefix, $path)
    {
        $prefixChars = str_split(str_replace('\\', '/', $prefix));
        $pathChars   = str_split(str_replace('\\', '/', $path));

        $lastSlash = 0;

        foreach ($prefixChars as $index => $char) {
            if ($char === '/') {
                $lastSlash = $index;
            }

            if ($char !== $pathChars[$index]) {
                return mb_substr($prefix, 0, $lastSlash);
            }
        }
    }
}
