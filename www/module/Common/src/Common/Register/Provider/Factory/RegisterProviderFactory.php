<?php

namespace Common\Register\Provider\Factory;

use C24\ZF2\User\Service\AuthenticationService;
use Common\Register\Provider\RegisterProvider;
use GuzzleHttp\RequestOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RegisterProviderFactory
 *
 * @package Common\Register\Provider\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterProviderFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RegisterProvider
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $api = $serviceLocator->get('ZendConfig')
            ->check24
            ->register
            ->api;

        return new RegisterProvider(
            $serviceLocator->get('GuzzleHttp\Client'),
            [
                'base_uri' => $api->scheme . $api->host . $api->base_uri,
                RequestOptions::AUTH => [
                    $api->user,
                    $api->pass
                ],
                RequestOptions::VERIFY => $api->verify_ssl
            ],
            $serviceLocator->get('HydratorManager')->get('ClassMethods'),
            $serviceLocator->get(AuthenticationService::class)
        );
    }
}