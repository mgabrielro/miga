<?php

namespace Common\View\Helper\Initializer;

use Common\Config\ConfigAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\InitializerInterface;

/**
 * Class ZendConfigInitializer
 *
 * @package Common\View\Helper\Initializer
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ZendConfigInitializer implements InitializerInterface
{
    /**
     * Initialize
     *
     * @param                         $instance
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return void
     */
    public function initialize($instance,ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ConfigAwareInterface)
        {
            $config = $serviceLocator->getServiceLocator()->get('ZendConfig');
            $instance->setConfig($config);
        }
    }
}