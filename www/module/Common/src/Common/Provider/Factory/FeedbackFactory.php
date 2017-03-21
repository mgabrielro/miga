<?php

namespace Common\Provider\Factory;

use Common\Provider\Feedback;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FeedbackFactory
 *
 * @package Common\Provider\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class FeedbackFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Feedback
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Feedback($serviceLocator->get('Common\Api\Client'));
    }
}