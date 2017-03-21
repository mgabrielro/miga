<?php

namespace Common\Config;

use Zend\Config\Config;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Initializer for config aware classes
 *
 * @package Common\Config
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ConfigInitializer implements InitializerInterface {

    /**
     * Initialize the config
     *
     * @param mixed $instance The instance to initialize
     * @param ServiceLocatorInterface $serviceLocator The service locator
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ConfigAwareInterface)
        {
            /** @var Config $config */
            $config  = $serviceLocator->get('ZendConfig');

            $instance->setConfig($config);
        }
    }
}