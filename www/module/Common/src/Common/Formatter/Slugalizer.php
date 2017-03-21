<?php

namespace Common\Formatter;

/**
 * Makes URI segments readable
 *
 * @author Robert Curth <robert.curth@check24.de>
 */
class Slugalizer
{
    /**
     * Makes URI segments readable
     *
     * @param string $text Text
     * @return string readable text
     */
    public function slugalize($text)
    {
        return str_replace(' ', '_', $text);
    }
}