<?php

namespace Common\Api\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ClientFactory
 *
 * @package Common\Service\Client
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ClientFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $api = $serviceLocator->get('ZendConfig')->check24->register->api;

        return new \GuzzleHttp\Client([
            'base_uri' => $api->host . $api->base_uri,
            'auth' => [$api->user, $api->pass]
        ]);
    }
}