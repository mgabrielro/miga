<?php

namespace Common\Formatter;

use Common\Validator\Check;

/**
 * Class ArrayFormatter.
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ArrayFormatter
{
    /**
     * Array prefix
     *
     * @param array  $array  Array
     * @param string $prefix Prefix
     *
     * @return array
     */
    public static function addPrefix(array $array, $prefix)
    {
        Check::is_array($array, 'array');
        Check::is_string($prefix, 'prefix');

        $newArray = [];

        // Add prefix to all elements
        foreach ($array as $key => $value) {
            $newArray[$prefix . $key] = $value;
        }

        return $newArray;
    }

    /**
     * remove prefix from array keys
     *
     * @param array   $array         Array
     * @param string  $prefix        Prefix
     * @param boolean $onlyPrefix    Add only elements to new array that includes prefix
     * @param boolean $excludePrefix Add only elements to new array that excludes prefix
     *
     * @return array
     */
    public static function removePrefix($array, $prefix, $onlyPrefix = false, $excludePrefix = false)
    {
        if (empty($array)) {
            return [];
        }

        Check::is_array($array, 'array');
        Check::is_string($prefix, 'prefix');
        Check::is_boolean($onlyPrefix, 'onlyPrefix');
        Check::is_boolean($excludePrefix, 'excludePrefix');

        $newArray = [];

        $len = mb_strlen($prefix);

        foreach ($array as $key => $value) {
            // Skip elements without prefix
            if ($onlyPrefix == true && strpos($key, $prefix) !== 0) {
                continue;
            }

            if ($excludePrefix == true && strpos($key, $prefix) === 0) {
                continue;
            }

            // Remove prefix and add to array
            if ($excludePrefix == false && strpos($key, $prefix) === 0) {
                $key = mb_substr($key, $len);
            }

            $newArray[$key] = $value;
        }

        return $newArray;
    }

    /**
     * Array selection
     *
     * Returns arrays with only containing key prefix
     *
     * @param array   $array        Array
     * @param string  $prefix       Prefix
     * @param boolean $removePrefix Remove prefix NOT IMPLEMENTED
     *
     * @return array
     */
    public static function selection($array, $prefix, $removePrefix = false)
    {
        Check::is_array($array, 'array');
        Check::is_string($prefix, 'prefix');
        Check::is_boolean($removePrefix, 'removePrefix');

        $newArray = [];

        foreach ($array as $key => $value) {
            // Skip elements without prefix
            if (strpos($key, $prefix) !== 0) {
                continue;
            }

            $newArray[$key] = $value;
        }

        return $newArray;
    }
}
