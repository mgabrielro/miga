<?php

namespace Common;

use Common\Listener\HtmlSpaceStripListener;
use Common\Listener\RouteListener;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 *
 * @package Common
 * @author Alexander Roddis <alexander.roddis@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Module
{
    /**
     * @const Current Version of Common Module
     */
    const VERSION = '1.0.0-dev';

    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        /** @var ServiceLocatorInterface $sm */
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');

        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');

        /** Register Aspect Manager */
        $serviceListener->addServiceManager(

            // The name of the plugin manager as it is configured in the service manager,
            // all config is injected into this instance of the plugin manager.
            'AspectManager',

            // The key which is read from the merged module.config.php files, the
            // contents of this key are used as services for the plugin manager.
            'aspect_manager',

            // The interface which can be specified on a Module class for injecting
            // services into the plugin manager, using this interface in a Module
            // class is optional and depending on how your autoloader is configured
            // it may not work correctly.
            'Common\Aop\Feature\AspectProviderInterface',

            // The function specified by the above interface, the return value of this
            // function is merged with the config from 'sample_plugins_config_key'.
            'getAspectConfig'
        );
    }


    /**
     * Get module configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @param \Zend\Mvc\MvcEvent $e The MvcEvent instance
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $this->attachEventListener($e);
        $this->enableLegacyHandler($application->getServiceManager());
    }

    /**
     * @param MvcEvent $e
     *
     * @return void
     */
    protected function attachEventListener(MvcEvent $e) {

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [new RouteListener(), 'onRoute'], 200);
        $eventManager->attach(MvcEvent::EVENT_FINISH, [new HtmlSpaceStripListener(), 'strip'], 100);
    }

    /**
     * enable legacy code handling
     *
     * @param ServiceManager $serviceManager
     */
    protected function enableLegacyHandler(ServiceManager $serviceManager)
    {
        /** initialize legacy config */
        \classes\config::init($serviceManager->get('ZendConfig'));

        /** set logger in legacy exception classes */
        \shared\classes\common\exception\base::set_logger($serviceManager->get('Logger'));
    }
}