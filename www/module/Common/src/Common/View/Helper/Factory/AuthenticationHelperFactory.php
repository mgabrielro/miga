<?php

namespace Common\View\Helper\Factory;

use Common\View\Helper\AuthenticationHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationHelperFactory
 *
 * @package Common\View\Helper\Factory
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AuthenticationHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AuthenticationHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AuthenticationHelper(
            $serviceLocator->getServiceLocator()->get("AuthenticationService")
        );
    }
}