<?php


    namespace classes\api\factory;


    use classes\api\fallback_api_client;
    use classes\api\participating_tariff;
    use classes\api\special_action;
    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class special_action_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $service = new special_action();

            $service->set_client(new fallback_api_client());

            return $service;
        }
    }