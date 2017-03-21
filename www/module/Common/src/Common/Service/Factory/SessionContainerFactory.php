<?php

namespace Common\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container AS Session_Container;

/**
 * Class SessionContainerFactory
 *
 * @package Common\Service\Factory
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class SessionContainerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Session_Container
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Session_Container('c24', $serviceLocator->get('Common\Session\Manager'));
    }
}