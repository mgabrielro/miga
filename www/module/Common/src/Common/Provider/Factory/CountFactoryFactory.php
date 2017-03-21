<?php

namespace Common\Provider\Factory;

use Common\Provider\CountFavorite;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the CountFavorite Provider for Api Call
 *
 * @package Common\Provider\Factory
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class CountFavoriteFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CountFavorite
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CountFavorite($serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }

}