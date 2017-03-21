<?php


    namespace classes\calculation\client\controller\pkv\factory;

    use classes\calculation\client as client;

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
                $serviceLocator->get('classes\calculation\client\client'),
                $serviceLocator->get('request')->getQuery()->toArray(),
                null,
                $serviceLocator->get('classes\calculation\client\client')->get_filter_position()
            );

            $controller->setServiceLocator($serviceLocator);

            return $controller;
        }
    }