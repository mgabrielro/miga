<?php

namespace Common\Config\Factory;

use Zend\Config\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ZendConfigFactory
 *
 * @package Common\Config\Factory
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ZendConfigFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new Config($serviceLocator->get('Config'));
    }
}