<?php

namespace Common\View\Helper\Factory;

use Common\View\Helper\MoneyFormat;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MoneyFormatFactory
 *
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class MoneyFormatFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $pluginManager
     *
     * @return MoneyFormat
     */
    public function createService(ServiceLocatorInterface $pluginManager)
    {
        return new MoneyFormat(
            $pluginManager->get('currencyformat')
        );
    }
}