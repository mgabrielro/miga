<?php

namespace Common\Log;

use Monolog\Logger;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Psr\Log\LoggerAwareInterface;

/**
 * Initializer for logger aware classes
 *
 * @package Common\Log
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class LogInitializer implements InitializerInterface
{
    /**
     * Initialize the logger
     *
     * @param mixed $instance The instance to initialize
     * @param ServiceLocatorInterface $serviceLocator The service locator
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof LoggerAwareInterface)
        {
            /** @var Logger $logger */
            $logger = $serviceLocator->get('Logger');
            $instance->setLogger($logger);
        }
    }
}