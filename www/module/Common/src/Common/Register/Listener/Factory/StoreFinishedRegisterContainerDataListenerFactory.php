<?php

namespace Common\Register\Listener\Factory;

use Common\Register\Listener\StoreFinishedRegisterContainerDataListener;
use Common\Register\Session\RegisterSessionStorageInterface;
use Interop\Container\ContainerInterface;

/**
 * Class StoreFinishedRegisterContainerDataListenerFactory
 *
 * @package Common\Register\Listener\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class StoreFinishedRegisterContainerDataListenerFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return StoreFinishedRegisterContainerDataListener
     */
    public function __invoke(ContainerInterface $container)
    {
        return new StoreFinishedRegisterContainerDataListener(
            $container->get(RegisterSessionStorageInterface::class)
        );
    }
}