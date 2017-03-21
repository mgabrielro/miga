<?php

namespace Common\Provider\Factory;

use Common\Provider\ConsultantData;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the ConsultantData Provider for Api Call
 *
 * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
 */
class ConsultantDataFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ConsultantData
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ConsultantData($serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }
    
}