<?php


    namespace classes\calculation\client\factory;


    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class form_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $output = $serviceLocator->get('DeviceOutput');
            return new \classes\calculation\client\form(
                $output->get(),
                $serviceLocator->get('Desktop\Form\Form'),
                $serviceLocator->get('Request')
            );
        }
    }