<?php

    namespace classes\helper\factory;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class c24points_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return \classes\helper\c24points
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $service = new \classes\helper\c24points(
                $serviceLocator->get('C24Login')
            );

            return $service;
        }
    }