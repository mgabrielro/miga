<?php

namespace Mobile;

use Mobile\Listener\DispatchListener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package Mobile
 */
class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) {
        $this->attachEventListener($e);

        // Init the currency helper:
        $serviceMangager = $e->getApplication()->getServiceManager();
        $serviceMangager->get('ViewHelperManager')->get('currencyformat')->setCurrencyCode('EUR')->setLocale('de_DE');
        $serviceMangager->get('ViewHelperManager')->get('numberformat')->setLocale('de_DE');

    }

    /**
     * Get module configuration
     *
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @param MvcEvent $e
     *
     * @return void
     */
    protected function attachEventListener(MvcEvent $e) {

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH, [new DispatchListener, 'onDispatch'], 100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
