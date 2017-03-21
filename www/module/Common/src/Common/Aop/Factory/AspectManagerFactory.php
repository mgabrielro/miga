<?php

namespace Common\Aop\Factory;

use Zend\Mvc\Service\AbstractPluginManagerFactory;

/**
 * Class AspectManager
 *
 * @package Common\Aop\Factory
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AspectManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = 'Common\Aop\AspectManager';
}