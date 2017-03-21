<?php


    namespace classes\calculation\mclient\controller\pkv\factory;

    use classes\calculation\mclient as client;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class result_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return client\controller\pkv\form
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $controller = new client\controller\pkv\result(
                $serviceLocator->get('classes\calculation\mclient\client'),
                $serviceLocator->get('request')->getQuery()->toArray(),
                null,
                $serviceLocator->get('classes\calculation\mclient\client')->get_filter_position()
            );

            $controller->setServiceLocator($serviceLocator);

            return $controller;
        }
    }