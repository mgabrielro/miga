<?php

    namespace classes\calculation\mclient\factory;

    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;
    use classes\calculation\mclient\client AS calculation_client;

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

            $wpset = $serviceLocator->get('classes\wpset');
            $tracking_id = $wpset->get_tracking_id($c24_config->product->id);

            $api = $c24_config->calculation->api;

            $client = new calculation_client(
                $api->host,
                $api->user,
                $api->pass,
                $api->log_path,
                'module/classes/calculation/mclient/view/', /*$api->view_path,*/
                $c24_config->partner_id,
                $tracking_id,
                $request->getQuery("tid2", ""),
                $request->getQuery("tid3", ""),
                $request->getQuery("tid4", ""),
                $request->getQuery("mode_id", ""),
                'check24-bluegrey-mobile',
                '/pkv/antragstrecke/einsprung/', /*$api->register_link, $router->assemble(array(), array('name'=>'mobile/pkv/register_create'))*/
                $router->assemble(array(), array('name'=>'ajax_json'/*, 'force_canonical'=>true*/)), /* ajax route */
                calculation_client::FILTER_POSITION_TOP,
                '',
                $request->getUri()->getScheme(),
                '',
                'mobile'
            );

            $client->set_filecache_path($c24_config->cache_path);
            $client->set_devicetype(calculation_client::DEVICE_TYPE_MOBILE);

            $deviceoutput = $serviceLocator->get('DeviceOutput')->get();
            $client->set_deviceoutput($deviceoutput);

            // overwrite links created in constructor from $_SERVER
            $client->add_link('result',        $router->assemble(array(), array('name'=>'mobile/pkv/result')));
            $client->add_link('form',          $router->assemble(array(), array('name'=>'mobile/pkv/input1')));
            $client->add_link('tariff_detail', $router->assemble(array(), array('name'=>'mobile/pkv/tariffdetail')));
            $client->add_link('result_pdf',    $router->assemble(array(), array('name'=>'mobile/pkv/tariffdetail')));

            return $client;

        }
    }
