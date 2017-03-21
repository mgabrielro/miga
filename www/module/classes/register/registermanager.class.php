<?php

    namespace classes\register {

        use Psr\Log\LoggerAwareInterface;
        use Psr\Log\LoggerAwareTrait;
        use Zend\ServiceManager\ServiceLocatorAwareInterface;
        use Zend\ServiceManager\ServiceLocatorInterface;

        /**
         * Register manager
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class registermanager implements ServiceLocatorAwareInterface, LoggerAwareInterface {

            use LoggerAwareTrait;

            /** @var integer */
            private $product_id = 0;
            /** @var \Zend\InputFilter\InputFilter|NULL */
            private $inputfilter = NULL;
            /** @var \classes\form|NULL */
            private $form = NULL;
            /** @var string Md5 hash */
            private $registercontainer_id = '';
            /** @var array */
            private $assigned_data = [];
            /** @var array */
            private $assigned_layout = [];
            /** @var steps\base|NULL */
            private $step = NULL;
            /** @var \shared\classes\calculation\client\model\parameter|NULL */
            private $calculationparameter = NULL;
            /** @var \shared\classes\calculation\client\model\tariff|NULL */
            private $registertariff = NULL;
            /** @var array */
            private $steps = [];
            /** @var array */
            private $step_information = [];
            /** @var string */
            private $step_before = '';
            /** @var string */
            private $current_step = '';

            /** @var \shared\classes\register\client\response */
            private $response_request;
            /** @var \shared\classes\register\client\response */
            private $response_submit;

            /** @var registercontroller */
            private $controller = NULL;
            /** @var client\client|NULL */
            private static $registerclient = NULL;

            /**
             * @var array
             */
            private $pointplan_data = [];

            /**
             * @var array
             */
            private $centrallogin_data = [];

            /**
             * @var ServiceLocatorInterface
             */
            protected $serviceLocator;


            /**
             * Set serviceManager instance
             *
             * @param ServiceLocatorInterface $serviceLocator The service locator
             * @return void
             */
            public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
                $this->serviceLocator = $serviceLocator;
            }

            /**
             * Retrieve serviceManager instance
             *
             * @return ServiceLocatorInterface
             */
            public function getServiceLocator() {
                return $this->serviceLocator;
            }

            /**
             * Get registerclient
             *
             * @return \shared\classes\register\client\client
             */
            public static function get_registerclient() {

                if (self::$registerclient === NULL) {

                    self::$registerclient = new \classes\register\client\client(
                        \classes\config::get('register_api_host'),
                        \classes\config::get('register_api_user'),
                        \classes\config::get('register_api_pass')
                    );

                }

                return self::$registerclient;

            }

            /**
             *
             * @return bool
             */
            public function is_c24login_active(){
                return false;
            }

            /**
             * Is http post method
             *
             * @return boolean
             */
            protected function is_post() {
                return $_SERVER['REQUEST_METHOD'] == 'POST';
            }

            /**
             * Create factory
             *
             * @param registercontroller $controller Controller
             * @param integer $product_id Product id
             * @param string $registercontainer_id Registercontainer id
             *
             * @throws \Exception Unknown product
             * @return registermanager
             */
            public static function create(registercontroller $controller, $product_id, $registercontainer_id) {

                if (product_id_exists($product_id)) {
                    return new registermanager($controller, $product_id, $registercontainer_id);
                } else {
                    throw new \Exception('Unknown product');
                }

            }

            /**
             * Create registercontainer
             *
             * @param string $calculationparameter_id Calculationparameter id
             * @param integer $product_id Product id
             * @param integer $tariffversion_id Tariffversion id
             * @param string $tariffversion_variation_key Tariffversion variation key
             * @param string $subscriptiontype Subscription type
             * @param string $deviceoutput Device output
             * @param string $devicetype   Device type
             * @param string $referer_url Referer url
             *
             * @throws \shared\classes\common\exception\logic Exception
             * @return array
             */
            public static function create_registercontainer($calculationparameter_id, $product_id, $tariffversion_id, $tariffversion_variation_key, $subscriptiontype, $deviceoutput, $devicetype, $referer_url = '') {

                $response = self::get_registerclient()->create_registercontainer(
                    $calculationparameter_id,
                    $product_id,
                    $tariffversion_id,
                    $tariffversion_variation_key,
                    $subscriptiontype,
                    $deviceoutput,
                    $devicetype,
                    $referer_url
                );

                if ($response->get_status_code() == 200) {
                    return $response->get_data();
                } else {

                    throw new \shared\classes\common\exception\logic(
                          $response->get_status_message() . PHP_EOL
                        . print_r($response->get_data(), 1)
                    );

                }

            }

            /**
             * Handle subscription type
             *
             * @param string $registercontainer_id Registercontainer id
             * @param integer $product_id Product id
             * @param string $type Type
             * @return string
             */
            public static function handle_subscription_type($registercontainer_id, $product_id, $type) {

                $response = self::get_registerclient()->post_step_data(
                    self::get_product_name($product_id),
                    $registercontainer_id,
                    array('subscriptiontype' => $type),
                    'onlineoffline_energy'
                );

                if ($response->get_status_code() != 200) {
                    return 'result';
                } else {
                    $data = $response->get_data();
                    return self::get_next_step('onlineoffline_energy', $data['steps']);
                }

            }

            /**
             * Constructor
             *
             * @param registercontroller $controller Controller
             * @param integer $product_id Product id
             * @param string $registercontainer_id Register container id
             *
             * @return void
             */
            public function __construct(registercontroller $controller, $product_id, $registercontainer_id) {

                $this->product_id = $product_id;
                $this->controller = $controller;
                $this->registercontainer_id = $registercontainer_id;

            }

            /**
             * @param \classes\form|NULL $form
             *
             * @return void
             */
            public function set_form($form) {
                $this->form = $form;
            }

            /**
             * @param NULL|\Zend\InputFilter\InputFilter $inputfilter
             *
             * @return void
             */
            public function set_inputfilter($inputfilter) {
                $this->inputfilter = $inputfilter;
            }


            /**
             * Run register manager
             *
             * @param string $current_step Current step (defaults to empty)
             * @return \Zend\Http\PhpEnvironment\Response|NULL
             */
            public function run($current_step = '') {

                $this->current_step = $current_step;

                // Do request to get step definition

                $this->response_request = self::get_registerclient()->get_step_definition(
                    self::get_product_name($this->get_product_id()),
                    $this->get_registercontainer_id(),
                    $current_step
                );

                // TODO: match response data for error. if so redirect to error page

                $response_data = $this->response_request->get_data();

                if ($this->response_request->get_status_code() != 200) {

                    // Check invalid parameter: container deleted, redirect to start

                    if ($this->response_request->get_status_message() == 'Invalid parameter') {
                        if ($this->get_current_step() == 'converted') {
                            return 'refresh_converted';
                        } else {
                            // Removing the data from the session, which were saved for the refreshing of the converted page
                            $session_container = $this->getServiceLocator()->get('SessionContainer');
                            /** @var \Zend\Session\Storage\StorageInterface $storage */
                            $storage = $session_container->getManager()->getStorage();

                            // Check for existing converted values.
                            // This indicates that the user used browser back, or has at least
                            // seen the converted step, so we simply return him to the correct
                            // input1 step of this product

                            if (isset($storage->converted) && $current_step === 'address') {
                                $storage->clear('converted');
                            }

                            $this->logger->info('Redirect to Input1');
                            return $this->controller->redirect_to_result_form_url($this->get_product_id());

                        }
                    }

                    // If status code is 551, session is expired, logout user

                    if (isset($response_data['code']) && $response_data['code'] == 551) {
                        return $this->controller->redirect()->toRoute('user/logout');
                    }

                    // We want to see the response from request on development and staging.
                    if (\classes\config::get('environment') != 'production') {
                        return dump($this->response_request);
                    }

                    if ($this->response_request->get_status_message() == 'Invalid parameter') {
                        return $this->controller->redirect_to_result_form_url($this->get_product_id());
                    } else {

                        return $this->controller->redirect_calculation_result_url(
                            $this->get_product_id(),
                            $response_data['calculationparameter']['id']
                        );

                    }

                }

                if ($current_step == '') {
                    $this->current_step = $current_step = $response_data['steps'][0]['name'];
                } else {

                    // Check api redirect to differant module

                    $api_step = '';

                    for ($i = 0, $i_max = count($response_data['steps']); $i < $i_max; ++$i) {

                        if ($response_data['steps'][$i]['status'] == 'current') {
                            $api_step = $response_data['steps'][$i]['name'];
                            break;
                        }

                    }

                    if ($api_step != $current_step) {
                        $this->controller->redirect_to_step($this->get_registercontainer_id(), $this->get_product_id(), $api_step);
                        return NULL;
                    }

                }

                // Create objects

                $this->registertariff = \classes\calculation\client\model\tariff\base::create($this->product_id, $response_data['registertariff']);
                $this->pointplan_data = (isset($response_data['pointplan_data'])) ? $response_data['pointplan_data']: null;
                $this->calculationparameter = \classes\calculation\client\model\parameter\base::create($this->product_id, $response_data['calculationparameter']);
                $this->steps = $response_data['steps'];
                $this->step_information = $response_data['step_information'];
                $this->centrallogin_data = (isset($response_data["centrallogin_data"])) ? $response_data["centrallogin_data"]: null;

                // Unset online offline because we have those links in tariff details

                //unset($this->steps[0]);
                $this->steps = array_merge($this->steps);

                // Set step before

                $this->step_before = self::get_step_before($current_step, $this->get_steps());

                $this->assign_layout('result_link', $this->controller->generate_calculation_result_url(
                    $this->get_product_id(),
                    $this->get_calculationparameter()->get_id()
                ));

                if ($this->step_before == 'result') {

                    $this->assign_layout('back_link', $this->controller->generate_result_url(
                        $this->get_product_id(),
                        $this->get_calculationparameter()->get_id(),
                        $this->get_registertariff()->get_tariff_version_id(),
                        $this->get_registertariff()->get_tariff_variation_key()
                    ));

                } else {

                    if ($current_step == 'converted') {
                        $this->assign_layout('menu_link', '//m.check24.de');
                    } else {
                        $this->assign_layout('back_link', $this->controller->generate_step_url($this->get_registercontainer_id(), $this->get_product_id(), $this->step_before));
                    }

                }

                // Assign tariff to layout (header)

                $this->assign_layout('tariff', $this->get_registertariff());
                $this->assign_layout('ssl', 'yes');

                // Create step and fill with response data

                $this->step = steps\base::create($current_step, $this, $response_data);
                $this->step->setLogger($this->logger);
                if($this->serviceLocator instanceof ServiceLocatorInterface) {
                    $this->step->setServiceLocator($this->getServiceLocator());
                }
                $res = $this->step->handle_request();

                if ($res == false) {
                    return NULL;
                }

                // Let form input filter known

                $this->get_form()->setInputFilter($this->get_inputfilter());

                if ($this->is_post() == false) {
                    $this->step->handle_load();
                } else {

                    // Do prevalidation

                    $x = $this->get_form()->setData($_POST);

                    // FIXME: this doesn't do anything

                    if ($this->get_form()->isValid()) {
                        $this->step->handle_submit();
                    }

                    // Valdate with api

                    $this->response_submit = self::get_registerclient()->post_step_data(
                        $this->get_product_name($this->get_product_id()),
                        $this->get_registercontainer_id(),
                        $this->get_form()->getData(),
                        $current_step
                    );

                    if ($this->response_submit->get_status_code() == 200) {

                        $response_data = $this->response_submit->get_data();
                        $this->step->set_register_data($response_data);

                        // Refresh data

                        $this->steps = $response_data['steps'];
                        $this->step_information = $response_data['step_information'];

                        if ($response_data['status'] == 'FORM_ERROR') {
                            // Refresh form definition
                            //@TODO: No time to fix this. But the Form should not be instantiated here but fetched from the DI-Container!
                            //@TODO: Make DI-Container available here // Support Mobile or Desktop form class
                            $formClassName = get_class($this->form); // can be mobile or desktop form
                            $this->form = new $formClassName($this->form->get_renderer());
                            $this->inputfilter = new \Zend\InputFilter\InputFilter();
                            $this->step->handle_form_definition();

                            // Set error messages

                            $this->step->handle_error();

                            $error_messages = array();

                            foreach ($response_data['form_error'] AS $field => $msg) {
                                $error_messages[$field]['api'] = \classes\register\translation::t($msg);
                            }

                            $this->get_form()->setMessages(
                                $error_messages
                            );

                        } else {
                            return $this->step->handle_success();
                        }

                    }

                }

                return NULL;

            }

            /**
             * Get product id
             *
             * @return integer
             */
            public function get_product_id() {
                return $this->product_id;
            }

            /**
             * Get registercontainer id
             *
             * @return string
             */
            public function get_registercontainer_id() {
                return $this->registercontainer_id;
            }

            /**
             * Get product name
             *
             * @param integer $product_id Product id
             *
             * @throws \Exception Unknown product
             * @return string
             *
             * @todo refactor
             */
            public static function get_product_name($product_id) {

                if (product_id_exists($product_id)) {
                    return get_def('product/' . $product_id);
                } else {
                    throw new \Exception('Unknown product');
                }

            }

            /**
             * Get product name translated
             *
             * @param integer $product_id Product id
             *
             * @throws \Exception Unknown product
             * @return string
             *
             * @todo refactor
             */
            public static function get_product_name_translated($product_id) {

                if (product_id_exists($product_id)) {
                    return get_def('products/' . $product_id . '/name');
                } else {
                    throw new \Exception('Unknown product');
                }

            }

            /**
             * Get form
             *
             * @return \classes\form
             */
            public function get_form() {
                return $this->form;
            }

            /**
             * Get input filter
             *
             * @return \Zend\InputFilter\InputFilter
             */
            public function get_inputfilter() {
                return $this->inputfilter;
            }

            /**
             * Get next step
             *
             * @param string $current_step Current step
             * @param array $steps Steps
             * @return string
             */
            public static function get_next_step($current_step, array $steps) {

                $current_index = NULL;
                $next_index = NULL;

                if ($current_step == '') {
                    $current_index = 0;
                } else {

                    for ($i = 0, $i_max = count($steps); $i < $i_max; ++$i) {

                        if ($steps[$i]['name'] == $current_step) {
                            $current_index = $i;
                        }

                        if ($steps[$i]['status'] == 'next') {
                            $next_index = $i;
                        }

                    }

                }

                if ($next_index) {
                    return $steps[$next_index]['name'];
                }

                if (!isset($steps[$current_index + 1])) {
                    return '';
                } else {
                    return $steps[$current_index + 1]['name'];
                }

            }

            /**
             * Get step before
             *
             * @param string $current_step Current step
             * @param array $steps Steps
             * @return string
             */
            private static function get_step_before($current_step, array $steps) {

                $current_index = NULL;
                $before_index = NULL;

                if ($current_step == '') {
                    $current_index = 0;
                } else {

                    for ($i = 0, $i_max = count($steps); $i < $i_max; ++$i) {

                        if ($steps[$i]['name'] == $current_step) {
                            $current_index = $i;
                        }


                        if ($steps[$i]['status'] == 'before') {
                            $before_index = $i;
                        }

                    }

                }

                if ($before_index) {
                    return $steps[$before_index]['name'];
                }

                if (!isset($steps[$current_index - 1])) {
                    return 'result';
                } else {
                    return $steps[$current_index - 1]['name'];
                }

            }

            /**
             * Assign data to view
             *
             * @param string $key Key
             * @param mixed $data Data
             * @return void
             */
            public function assign_data($key, $data) {
                $this->assigned_data[$key] = $data;
            }

            /**
             * Assign to layout
             *
             * @param string $key Key
             * @param mixed $data Data
             *
             * @return void
             */
            public function assign_layout($key, $data) {
                $this->assigned_layout[$key] = $data;
            }

            /**
             * Get assigned data
             *
             * @return array
             */
            public function get_assigned_data() {
                return $this->assigned_data;
            }

            /**
             * Get assigned layout
             *
             * @return array
             */
            public function get_assigned_layout() {
                return $this->assigned_layout;
            }

            /**
             * Get step view
             *
             * @return string
             */
            public function get_step_view() {
                return $this->step->get_view();
            }

            /**
             * Get registertariff
             *
             * @return \shared\classes\calculation\client\model\tariff
             */
            public function get_registertariff() {
                return $this->registertariff;
            }

            /**
             * Get calculationparameter
             *
             * @return \shared\classes\calculation\client\model\parameter
             */
            public function get_calculationparameter() {
                return $this->calculationparameter;
            }

            /**
             * Get steps
             *
             * @return array
             */
            public function get_steps() {
                return $this->steps;
            }

            /**
             * Get step information
             *
             * @param string $key Optional key for direct key access
             * @return array
             */
            public function get_step_information($key = NULL) {

                if ($key !== NULL) {

                    if (array_key_exists($key, $this->step_information)) {
                        return $this->step_information[$key];
                    } else {
                        return NULL;
                    }

                } else {
                    return $this->step_information;
                }

            }

            /**
             * Get controller
             *
             * @return registercontroller
             */
            public function get_controller() {
                return $this->controller;
            }

            /**
             * Get Submit response
             *
             * @return registercontroller
             */
            public function get_response_submit() {
                return $this->response_submit;
            }

            /**
             * Get the current step
             *
             * @return string Step name
             */
            public function get_current_step() {
                return $this->current_step;
            }

            /**
             *
             * @return array
             */
            public function get_pointplan_data(){
                return $this->pointplan_data;
            }

            /**
             *
             * @return array
             */
            public function get_centrallogin_data(){
                return $this->centrallogin_data;
            }

        }

    }
