<?php

namespace Common\Provider\Factory;

use Common\Provider\City;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CityFactory
 *
 * @package Common\Provider\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class CityFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return City
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new City($serviceLocator->get('Common\Api\Client'));
    }
}