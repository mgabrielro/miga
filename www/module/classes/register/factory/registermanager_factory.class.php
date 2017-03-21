<?php


    namespace classes\register\factory;


    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    class registermanager_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {
            $application = $serviceLocator->get('Application');

            $routeMatch = $application->getMvcEvent()->getRouteMatch();

            $controller = $application->getMvcEvent()->getTarget();

            $manager = \classes\register\registermanager::create(
                $controller,
                $routeMatch->getParam('product_id'),
                $routeMatch->getParam('registercontainer_id')
            );

            $controllerNamespace = substr(get_class($controller), 0, strpos(get_class($controller), '\\'));

            $manager->set_inputfilter(new \Zend\InputFilter\InputFilter());

            switch ($controllerNamespace) {
                case 'Application':
                    $manager->set_form($serviceLocator->get('Desktop\Form\Form'));

                    break;

                case 'Mobile':
                    $manager->set_form($serviceLocator->get('Mobile\Form\Form'));

                    break;
            }

            return $manager;
        }
    }