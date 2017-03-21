<?php
namespace Common\Service\Factory;

use Common\Service\DeviceType;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Builds the Device service
 * @author Robert Curth <robert.curth@check24.de>
 */
class DeviceTypeFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $request = $serviceLocator->get('Request');
        $wurfl = $serviceLocator->get('Wurfl');

        return new DeviceType($request, $wurfl);
    }
}