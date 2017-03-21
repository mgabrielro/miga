<?php

namespace Common\Session\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemcacheFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $memcached = $serviceLocator->get('ZendConfig')->check24->memcached;
        return new \Common\Session\SaveHandler\Memcache($memcached->host, $memcached->port);
    }
}