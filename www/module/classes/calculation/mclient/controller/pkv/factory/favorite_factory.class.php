<?php


    namespace classes\calculation\mclient\controller\pkv\factory;

    use classes\calculation\mclient as client;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    /**
     * Factory class to create an instance of the favorite client.
     *
     * Can be used for API Calls against the Desktop environment.
     *
     * @author Gabriel Mandu <gabriel.mandu@check24.de>
     */
    class favorite_factory implements FactoryInterface
    {

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return client\controller\pkv\favorite
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $controller = new client\controller\pkv\favorite(
                $serviceLocator->get('classes\calculation\mclient\client'),
                $serviceLocator->get('request')->getQuery()->toArray()
            );

            $controller->setServiceLocator($serviceLocator);

            return $controller;

        }

    }

