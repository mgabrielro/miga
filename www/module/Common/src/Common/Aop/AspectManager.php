<?php

namespace Common\Aop;

use Go\Aop\Aspect;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class AspectManager
 *
 * @package Common\Aop
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AspectManager extends AbstractPluginManager
{
    /**
     * @param mixed $plugin
     *
     * @return void
     * @throws \RuntimeException
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof Aspect)
        {
            throw new \RuntimeException(sprintf(
                'Plugin of type %s is invalid; must implement Go\Aop\Aspect',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin))
            ));
        }
    }
}