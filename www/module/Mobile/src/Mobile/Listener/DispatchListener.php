<?php

    namespace Mobile\Listener;

    use Zend\Mvc\MvcEvent;

    class DispatchListener {

        /**
         * Adjusts the request path with trailing slash if missing.
         *
         * @param MvcEvent $event MvcEvent
         *
         * @return void
         */
        public function onDispatch(MvcEvent $event) {

            $controller          = $event->getTarget();
            $controllerClass     = get_class($controller);
            $controllerNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $listenerNamespace   = substr(__CLASS__, 0, strpos(__CLASS__, '\\'));


            if ($controllerNamespace == $listenerNamespace) {

                $step = $controller->getEvent()->getRouteMatch()->getParam('step');

                if ($step !== 'converted' || is_null($step)) {
                    $controller->layout('layout/main');
                } else {
                    $controller->layout('layout/thankyou');
                }

            }

        }

    }