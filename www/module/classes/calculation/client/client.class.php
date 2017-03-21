<?php

    namespace classes\calculation\client;

    use \shared\classes\calculation\client AS shared_client;
    use \shared\classes\common\utils;
    use \shared\classes\calculation\client\controllerstatus;
    use \shared\classes\common\exception;

    use Zend\Http\Request;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * client
     *
     * Calculation client
     *
     * @author Everyone
     */
    class client extends \shared\classes\calculation\client\client implements ServiceLocatorAwareInterface {

        use ServiceLocatorAwareTrait;

        /**
         * Get calculation models
         *
         * @param integer $product_id Product id
         * @param array $parameter Parameter
         * @param array $include List of models to include, NULL for parameter+result+paging
         * @return array
         */
        public function get_calculation_models($product_id, $parameter, array $include = NULL) {

            utils::check_int($product_id, 'product_id');
            utils::check_array($parameter, 'parameter', true);

            $response = $this->get_calculation($product_id, $parameter);

            if ($response->get_status_code() == 500) {
                throw new exception\logic('Server has 500er error - calculation failed');
            } else if ($response->get_status_code() == 400) {
                throw new exception\argument('Missing or invalid parameter: '
                    . implode(', ', array_keys($response->get_data())));
            }

            if ($include === NULL) {
                $include = array('parameter', 'result');
            }

            $data = $response->get_data();
            $result = array();

            for ($i = 0, $max = count($include); $i < $max; ++$i) {

                switch ($include[$i]) {

                    case 'parameter':

                        $result['parameter'] = model\parameter\base::create($product_id, $data['parameter']);
                        break;

                    case 'result':

                        $models = array();

                        while (list($index, $tariff) = @each($data['result'])) {
                            $tariff = model\tariff\base::create($product_id, $tariff);
                            $models[] = $tariff;
                        }

                        $result['result'] = $models;
                        break;

                    case 'evaluation':

                        $models = array();

                        if ($data['evaluation'] !== NULL) {

                            foreach ($data['evaluation'] AS $company_id => $evaluation) {
                                $models[$company_id] = new shared_client\model\evaluationextend($evaluation);
                            }

                        }

                        $result['evaluation'] = $models;
                        break;

                    default:

                        throw new exception\argument('Unknown model requested: ' . $include[$i]);

                }

            }

            return $result;

        }

        /**
         * Get calculationparameter
         *
         * @param integer $product_id Product ID
         * @param string $id Calculationparameter ID
         * @return \shared\classes\calculation\client\model\parameter
         */
        public function get_calculationparameter($product_id, $id) {

            utils::check_int($product_id, 'product_id');
            utils::check_string($id, 'id');

            $calculationparameter_response = $this->handle_calculationparameter(
                $product_id,
                'get',
                array('calculationparameter_id' => $id)
            );

            if ($calculationparameter_response->get_status_code() != 200) {
                throw new exception\logic('Calculation parameter getting failed');
            }

            return model\parameter\base::create($product_id, $calculationparameter_response->get_data());

        }

        /**
         * Get pkv form
         *
         * @param array $parameters Preset parameters
         * @return controllerstatus
         */
        public function handle_controller_pkv_form(\Zend\Http\Request $request) {

            $controller = new controller\pkv\form($this, $request->getQuery()->toArray());
            $controller->setServiceLocator($this->serviceLocator);

            return $controller->run();

        }

        /**
         * Get pkv result pdf
         *
         * @param array $parameters Preset parameters
         * @return controllerstatus
         */
        public function handle_controller_pkv_result_pdf(\Zend\Http\Request $request) {

            $controller = new controller\pkv\result_pdf($this, $request->getQuery()->toArray());

            return $controller->run();

        }

        /**
         * Get pkv result
         *
         * @param array $parameters Result parameters
         * @param response $response Response
         * @return controllerstatus
         */
        public function handle_controller_pkv_result(\Zend\Http\Request $request, $response = NULL) {

            utils::check_object($response, 'response', true);

            $controller = new controller\pkv\result($this, $request->getQuery()->toArray(), $response, $this->get_filter_position());
            $controller->setServiceLocator($this->serviceLocator);

            return $controller->run();

        }

        /**
         * Get pkv compare
         *
         * @param array $parameters Result parameters
         * @param response $response Response
         * @return controllerstatus
         */
        public function handle_controller_pkv_compare(\Zend\Http\Request $request, $response = NULL) {

            utils::check_object($response, 'response', true);

            $controller = new controller\pkv\compare($this, $request->getQuery()->toArray());
            $controller->setServiceLocator($this->serviceLocator);

            return $controller->run();
        }

        /**

         * Get pkv tariff details
         *
         * @param array $parameters Result parameters
         * @param response $response Response
         * @return controllerstatus
         */
        public function handle_controller_pkv_tariff_detail(\Zend\Http\Request $request, $response = NULL) {

            utils::check_object($response, 'response', true);

            $controller = new controller\pkv\tariff_detail($this, $request->getQuery()->toArray(), $response);
            $controller->setServiceLocator($this->serviceLocator);

            return $controller->run();

        }

        /**

         * Handle pkv automatically
         *
         * @param array $parameters Parameters
         * @param string $default_controller Default startup controller
         * @return string
         */
        public function handle_controller_pkv(\Zend\Http\Request $request, $default_controller = 'form') {

            utils::check_string($default_controller, 'default_controller');

            $controller = $request->getQuery('c24_controller') ? trim($request->getQuery('c24_controller')) : $default_controller;

            switch ($controller) {

                case 'form' :

                    $status = $this->handle_controller_pkv_form($request);

                    if ($status->get_status() == controllerstatus::SUCCESS || $status->get_status() == controllerstatus::FORM_ERROR) {
                        return $status->get_output();
                    } else {
                        $api_parameters = $status->get_response()->get_data('parameter');

                        // repackage array into Request object again
                        $request = new Request();
                        $request->getQuery()->fromArray(array_prefix('c24api_', $api_parameters));

                        return $this->handle_controller_pkv_result($request, $status->get_response())->get_output();
                    }

                case 'result' :

                    $status = $this->handle_controller_pkv_result($request);

                    return $status->get_output();

                case 'tariff_detail' :

                    $status = $this->handle_controller_pkv_tariff_detail($request);

                    return $status->get_output();

                case 'result_pdf' :

                    $status = $this->handle_controller_pkv_result_pdf($request);

                    if ($status->get_status() == controllerstatus::SUCCESS || $status->get_status() == controllerstatus::FORM_SUCCESS) {
                        $status_code = 200;
                        $status_string = 'OK';
                    } else {
                        $status_code = 400;
                        $status_string = 'Bad Request';
                    }

                    header('HTTP/1.1 ' . $status_code . ' ' . $status_string);

                    if ($status->get_status() == controllerstatus::SUCCESS || $status->get_status() == controllerstatus::FORM_SUCCESS) {

                        header('Content-Type: application/pdf');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('content-disposition: attachment; filename="Strom-Vergleichsergebnis.pdf"');
                        header('Expires: -1');
                        header('Connection: close');
                        header('Pragma: hack'); // insane is needed for https IE fix
                        header('Content-Length: ' . strlen($status->get_output()));

                    }

                    if (is_array($status->get_output())) {
                        echo implode("\n", $status->get_output());
                    } else {
                        echo $status->get_output();
                    }

                    exit(0);

                case 'compare' :

                    $status = $this->handle_controller_pkv_compare($request);

                    return $status->get_output();

                default :

                    throw new exception\argument('Invalid controller "' . $controller . '"');

            }

        }

        /**
         * Get rest client instance
         *
         * @param string $hostname Hostname
         * @param string $username Username
         * @param string $password Password
         * @param boolean $throws Throws
         * @return \shared\classes\common\rs_rest_client\rs_rest_client Rs rest client instance
         */
        protected function get_rest_client($hostname, $username, $password, $throws) {

            utils::check_string($hostname, 'hostname');
            utils::check_string($username, 'username');
            utils::check_string($password, 'password');
            utils::check_bool($throws, 'throws');

            return new \shared\classes\common\rs_rest_client\rs_rest_client(
                $hostname, $username, $password, $throws
            );

        }

        /**
         * Validated a given product_id
         *
         * @param integer $product_id Product id to be checked
         * @throws \Exception Raised if product_id is not valid
         * @return void
         */
        protected function validate_product_id($product_id) {

            if (!product_id_exists($product_id)) {
                throw new exception\logic('Given product_id (' . $product_id . ') not valid.');
            }

        }

    }



