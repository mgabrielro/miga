<?php

    namespace classes\calculation\client\factory;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;
    use classes\calculation\client\client AS calculation_client;

    class client_factory implements FactoryInterface{

        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return mixed
         */
        public function createService(ServiceLocatorInterface $serviceLocator) {

            $c24_config = $serviceLocator->get("ZendConfig")->check24;

            /**
             * @var $request \Zend\Http\Request
             */
            $request = $serviceLocator->get("Request");

            /** @var \Zend\Mvc\Router\Http\TreeRouteStack $router */
            $router  = $serviceLocator->get("Router");

            $api = $c24_config->calculation->api;

            $client =  new calculation_client(
                $api->host,
                $api->user,
                $api->pass,
                $api->log_path,
                $api->view_path,
                $c24_config->partner_id,
                '',
                $request->getQuery("tid2", ""),
                $request->getQuery("tid3", ""),
                $request->getQuery("tid4", ""),
                $request->getQuery("mode_id", ""),
                'check24-bluegrey',
                $api->register_link,
                $router->assemble(array(), array('name'=>'ajax_json'/*, 'force_canonical'=>true*/)), /* ajax route */
                calculation_client::FILTER_POSITION_TOP,
                '',
                $request->getUri()->getScheme(),
                '',
                'desktop'
            );

            $client->set_filecache_path($c24_config->cache_path);
            $client->set_devicetype(calculation_client::DEVICE_OUTPUT_DESKTOP);

            // overwrite links created in constructor from $_SERVER
            $client->add_link('home',          $router->assemble(array(), array('name'=>'desktop/home')));
            $client->add_link('form',          $router->assemble(array(), array('name'=>'desktop/pkv/pkv_form')));
            $client->add_link('compare',       $router->assemble(array(), array('name'=>'desktop/pkv/compare', 'query' => ['c24_controller' => 'compare'])));
            $client->add_link('result',        $router->assemble(array(), array('name'=>'desktop/pkv/result', 'query' => ['c24_controller' => 'result'])));
            $client->add_link('result_pdf',    $router->assemble(array(), array('name'=>'desktop/pkv/result')));

            return $client;
        }
    }
