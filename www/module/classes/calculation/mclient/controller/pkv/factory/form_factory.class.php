<?php


    namespace classes\calculation\mclient\controller\pkv\factory;

    use classes\calculation\mclient as client;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class form_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return client\controller\pkv\form
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $controller = new client\controller\pkv\form(
                $serviceLocator->get('classes\calculation\mclient\client'),
                $serviceLocator->get('request')->getQuery()->toArray()
            );

            $controller->setServiceLocator($serviceLocator);

            return $controller;
        }
    }