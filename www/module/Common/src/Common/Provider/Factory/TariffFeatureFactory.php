<?php

namespace Common\Provider\Factory;

use Common\Provider\TariffFeature;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the TariffFeature Http Controller
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class TariffFeatureFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return TariffFeature
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TariffFeature($serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }
    
}