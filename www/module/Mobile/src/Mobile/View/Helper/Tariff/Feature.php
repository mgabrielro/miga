<?php

namespace Mobile\View\Helper\Tariff;

/**
 * Tariff feature view helper, renders strings "yes" and "no" as a check/cross-mark
 *
 * @armin Armin Beširović <armin.besirovic@check24.de>
 * @package Mobile\View\Helper\Tariff
 */
class Feature extends \Zend\View\Helper\AbstractHelper
{
    public function __invoke($featureText)
    {
        if (in_array($featureText, ['yes', 'no'])) {
            return sprintf('<div class="checkmark_%s"></div>',
                $featureText == 'yes' ? 'green' : 'red');
        }

        return htmlentities($featureText, ENT_QUOTES, 'UTF-8');
    }
}
