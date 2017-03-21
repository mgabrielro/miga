<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class TranslateEscaped
 *
 * @author  Lars Lenecke <lars.lenecke@check24.de>
 * @package Common\View\Helper
 */
class TranslateEscaped extends AbstractHelper
{
    /**
     * Translates and escapes a message
     *
     * @param  string $message
     * @param  string $textDomain
     * @param  string $locale
     * @return string
     */
    public function __invoke($message, $textDomain = null, $locale = null)
    {
        return $this->getView()->escapeHtml(
            $this->getView()->translate($message, $textDomain, $locale)
        );
    }

}
