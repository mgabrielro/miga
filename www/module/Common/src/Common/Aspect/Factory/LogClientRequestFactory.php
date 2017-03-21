<?php

namespace Common\Aspect\Factory;

use Common\Aspect\LogClientRequest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationServiceFactory
 *
 * @package Common\Service\Factory
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class LogClientRequestFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return LogClientRequest
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new LogClientRequest($serviceLocator->getServiceLocator()->get('Logger'));
    }
}