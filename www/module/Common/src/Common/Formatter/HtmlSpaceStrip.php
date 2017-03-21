<?php

namespace Common\Formatter;

/**
 * Class HtmlSpaceStrip
 *
 * @package Common\Formatter
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class HtmlSpaceStrip
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = self::strip($content);
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->content;
    }

    /**
     * Strip whitespace, blank lines etc. ("compress" html, better performance)
     *
     * @param string $string String
     * @return string
     */
    public static function strip($content)
    {
        $final = '';
        $lines = explode("\n", str_replace("\r", "\n", str_replace("\r\n", "\n", $content)));

        for ($i = 0, $max = count($lines); $i < $max; ++$i)
        {
            $line = $lines[$i];

            if (trim($line) == '') {
                continue;
            }

            if (substr(ltrim($line), 0, 1) == '<') {
                $line = ltrim($line);
            }

            if (substr(rtrim($line), -1) == '>') {
                $line = rtrim($line);
            }

            $final .= $line . "\n";
        }

        return substr($final, 0, -1);
    }
}