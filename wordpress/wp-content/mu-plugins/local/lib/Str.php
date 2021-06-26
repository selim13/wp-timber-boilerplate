<?php

namespace Local;

class Str
{
    /**
     * Determine if a given string contains a given substring.
     *
     * @param string $haystack
     * @param string|string[] $needles
     * @return bool
     */
    public static function contains(string $haystack, $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack
     * @param string|string[] $needles
     * @return bool
     */
    public static function ends_with(string $haystack, $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && substr($haystack, -strlen($needle)) === (string)$needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string|string[] $needles
     * @return bool
     */
    public static function starts_with(string $haystack, $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns plural form
     *
     * @param int $count
     * @param array $forms
     * @return string
     */
    public static function plural(int $count, array $forms): string
    {
        $abs = abs($count);
        $cases = array(2, 0, 1, 1, 1, 2);
        return $forms[($abs % 100 > 4 && $abs % 100 < 20) ? 2 : $cases[min($abs % 10, 5)]];
    }
}
