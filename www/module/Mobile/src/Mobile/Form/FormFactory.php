<?php

    namespace Mobile\Form;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class FormFactory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            return new \Mobile\Form\Form($serviceLocator->get('ViewRenderer'));
        }
    }