<?php

namespace Common\Session\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SessionManagerFactory
 *
 * @package Common\Session\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class SessionManagerFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new \Zend\Session\SessionManager(
            null,
            null,
            $serviceLocator->get('Common\Session\Memcache'));
    }
}