<?php

namespace Common\Service\Factory;

use Common\Service\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationServiceFactory
 *
 * @package Common\Service\Factory
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AuthenticationService($serviceLocator->get('C24Login'));
    }
}