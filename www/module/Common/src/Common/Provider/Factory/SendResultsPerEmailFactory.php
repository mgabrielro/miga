<?php

namespace Common\Provider\Factory;

use Common\Provider\SendResultsPerEmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the SendResultsPerEmail Provider for Api Call
 *
 * @package Common\Provider\Factory
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class SendResultsPerEmailFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SendResultsPerEmail
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SendResultsPerEmail($serviceLocator->get('Common\Api\Client'), $serviceLocator->get('Config'));
    }

}