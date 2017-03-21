<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class TranslateEscapedWithVars
 *
 * @package Common\View\Helper
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class TranslateEscapedWithVars extends AbstractHelper
{
    /**
     * Translates and escapes a message with vars
     *
     * @param  string $message
     * @param  array  $replaceTable
     * @param  string $textDomain
     * @param  string $locale
     *
     * @return string
     */
    public function __invoke($message, $replaceTable = [], $textDomain = null, $locale = null)
    {
        return strtr($this->getView()->escapeHtml(
            $this->getView()->translate($message, $textDomain, $locale)
        ), $replaceTable);
    }

}
