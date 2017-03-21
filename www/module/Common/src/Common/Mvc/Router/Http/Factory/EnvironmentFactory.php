<?php

namespace Common\Mvc\Router\Http\Factory;

use Common\Mvc\Router\Http\Environment;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;

/**
 * Class EnvironmentFactory
 *
 * @package Common\Mvc\Router\Http\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class EnvironmentFactory implements MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    /**
     * @param AbstractPluginManager $pluginManager
     *
     * @return Environment
     */
    public function __invoke(AbstractPluginManager $pluginManager)
    {
        return new Environment(
            $this->creationOptions['name'],
            $this->creationOptions['value']
        );
    }
}