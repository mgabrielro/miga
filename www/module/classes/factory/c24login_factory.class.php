<?php


    namespace classes\factory;

    use classes\device_output;
    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;
    use Zend\Session\Container AS Session_Container;

    class c24login_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $c24login = \classes\myc24login::get_instance();

            if (!empty($_COOKIE['c24session'])) {
                try {
                    $c24login->user_validate($_COOKIE['c24session'], true);
                } catch (\Exception $e) {
                    // do nothing
                }
            }
            return $c24login;
        }
    }