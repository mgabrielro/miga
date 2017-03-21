<?php

namespace Common\Provider\Factory;

use Common\Provider\Street;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class StreetFactory
 *
 * @package Common\Provider\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class StreetFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Street
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Street($serviceLocator->get('Common\Api\Client'));
    }
}