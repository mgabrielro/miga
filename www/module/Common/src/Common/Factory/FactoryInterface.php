<?php

namespace Common\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Interface FactoryInterface
 *
 * @author  Lars Lenecke <lars.lenecke@check24.de>
 * @package Common\Factory
 */
interface FactoryInterface {
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $pluginManager
     *
     * @return mixed
     */
    public function __invoke(ServiceLocatorInterface $pluginManager);
}
