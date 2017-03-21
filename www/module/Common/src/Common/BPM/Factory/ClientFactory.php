<?php

namespace Common\BPM\Factory;

use Common\BPM\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Client
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('ZendConfig')->check24->bpm;

        $domains = $config->domains->toArray();

        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => rtrim($domains[rand(0, count($domains)-1)], '/') . '/' . trim($config->base_uri, '/') . '/'
        ]);


        $cookieDomain = $serviceLocator->get('Request')->getUri()->getHost();
        $env = (string)getenv('APPLICATION_ENV');

        if ($env && !empty($config->cookie_domain->{$env})) {
            $cookieDomain = $config->cookie_domain->{$env};
        }

        return new Client(
            $config->service_id,
            $config->secret,
            $config->product_key,
            $cookieDomain,
            $httpClient
        );
    }

}