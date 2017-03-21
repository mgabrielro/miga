<?php

namespace Common\Provider\Factory;

use Common\Provider\TariffDetails;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the TariffDetails Http Controller
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class TariffDetailsFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TariffDetails
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new TariffDetails($serviceLocator->get('Request'), $serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }
}