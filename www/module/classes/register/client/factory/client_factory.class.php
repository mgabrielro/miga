<?php

    namespace classes\register\client\factory;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class client_factory implements FactoryInterface {

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return \classes\register\client\client
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $api_config = $serviceLocator->get("ZendConfig")->check24->register->api;

            $client = new \classes\register\client\client(
                $api_config->host,
                $api_config->user,
                $api_config->pass
            );

            return $client;

        }
    }
