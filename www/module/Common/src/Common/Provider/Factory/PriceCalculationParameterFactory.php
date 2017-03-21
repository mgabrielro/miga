<?php

namespace Common\Provider\Factory;

use Common\Provider\PriceCalculationParameter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PriceCalculationParameterFactory
 *
 * @package Common\Provider\Factory
 * @author Armin Beširović <armin.besirovic@check24.de>

 */
class PriceCalculationParameterFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PriceCalculationParameter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PriceCalculationParameter($serviceLocator->get('Common\Api\Client'));
    }
}