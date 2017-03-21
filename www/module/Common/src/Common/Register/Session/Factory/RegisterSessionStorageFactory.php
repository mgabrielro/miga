<?php

namespace Common\Register\Session\Factory;

use Interop\Container\ContainerInterface;
use VV\ZF\C24\Config\Config;
use Zend\Session\Container;

/**
 * Class RegisterSessionStorageFactory
 *
 * @package Common\Register\Session\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterSessionStorageFactory
{
    /**
     * @var string
     */
    const SESSION_CONTAINER_REGISTER_IDENTIFIER = 'c24Register';

    /**
     * @param ContainerInterface $container
     *
     * @return Container
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(Config::class);

        $sessionManagerKey = $config
            ->check24
            ->service_keys
            ->session
            ->manager;

        return new Container(
            static::SESSION_CONTAINER_REGISTER_IDENTIFIER,
            $container->get($sessionManagerKey)
        );
    }
}