<?php
namespace Common\View\Helper;
use Zend\View\Helper\AbstractHelper;

/**
 * Truncates text and optionally appends a string ("…" by default)
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 */
class TruncateHelper extends AbstractHelper {

    /**
     * Truncates $string to $length and optionally appends a string ("…" by default)
     * 
     * @param $string
     * @param $length
     * @param string $append
     * @return $this
     */
    public function __invoke($string, $length, $append = '…')
    {
        $string_length = mb_strlen($string);
        if ($string_length > $length) {
            $last_space = intval(mb_strrpos($string, ' '));

            if ($last_space < $length) {
                $string = mb_substr($string, $last_space);
            } else {
                $string = mb_substr($string, $length);
            }

            $string .= $append;
        }
        
        return $string;
    }
}
