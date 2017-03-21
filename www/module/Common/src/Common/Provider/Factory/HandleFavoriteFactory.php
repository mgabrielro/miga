<?php

namespace Common\Provider\Factory;

use Common\Provider\HandleFavorite;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the HandleFavorite Provider for Api Call
 *
 * @package Common\Provider\Factory
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class HandleFavoriteFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return HandleFavorite
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new HandleFavorite($serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }

}