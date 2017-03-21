<?php

namespace Common\Provider\Factory;

use Common\Provider\Occupation;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OcupationFactory
 *
 * @package Common\Provider\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class OccupationFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Occupation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Occupation($serviceLocator->get('Common\Api\Client'));
    }
}