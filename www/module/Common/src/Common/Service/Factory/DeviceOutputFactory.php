<?php
namespace Common\Service\Factory;

use Common\Service\DeviceOutput;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Builds the Device service
 * @author Robert Curth <robert.curth@check24.de>
 */
class DeviceOutputFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $request = $serviceLocator->get('Request');
        $device_type = $serviceLocator->get('DeviceType');
        $config = $serviceLocator->get('Config');

        $current_application = $config['check24']['current_application'];

        $config = $config['check24']['deviceoutput'][$current_application];

        return new DeviceOutput($request, $device_type, $config);
    }
}