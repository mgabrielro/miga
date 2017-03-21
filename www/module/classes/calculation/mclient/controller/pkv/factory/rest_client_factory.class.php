<?php

    namespace classes\calculation\mclient\controller\pkv\factory;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    /**
     * Factory class to create an instance of the rest client.
     *
     * Can be used for API Calls against the Desktop environment.
     *
     * @author Stefan Brandt <stefan.brandt@check24.de>
     */
    class rest_client_factory implements FactoryInterface
    {

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         * @return \shared\classes\common\rs_rest_client\rs_rest_client
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $c24_config = $serviceLocator->get("ZendConfig")->check24;
            $api = $c24_config->calculation->api;

            $client = new \shared\classes\common\rs_rest_client\rs_rest_client(
                $api->host,
                $api->user,
                $api->pass
            );

            return $client;

        }
    }
