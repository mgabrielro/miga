<?php


    namespace classes\factory;

    use classes\wpset;
    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class wpset_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return wpset
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $wpset = new wpset(
                $serviceLocator->get('SessionContainer'),
                new \shared\classes\dal\wpset(
                    $serviceLocator->get('\classes\calculation\client\client')
                ),
                $serviceLocator->get('Request'),
                $serviceLocator->get('Response')
            );

            return $wpset;
        }
    }