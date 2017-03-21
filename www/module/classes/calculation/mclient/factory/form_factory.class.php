<?php


    namespace classes\calculation\mclient\factory;


    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;
    use classes\device_output;

    class form_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $deviceoutput = $serviceLocator->get('DeviceOutput')->get();

            return new \classes\calculation\mclient\form(
                $deviceoutput,
                $serviceLocator->get('Mobile\Form\Form'),
                $serviceLocator->get('Request')
            );
        }
    }