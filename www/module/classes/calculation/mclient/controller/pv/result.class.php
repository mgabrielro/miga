<?php

    namespace classes\calculation\mclient\controller\pv {

        /**
         * Result energy render class for frontend.
         *
         * Base for gas and power derivations.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        abstract class result extends \shared\classes\calculation\client\controller\result {

            const VIEW_TYPE_RESULT        = 'result';
            const VIEW_TYPE_RESULT_HEADER = 'result_head';
            const VIEW_TYPE_RESULT_FOOTER = 'result_footer';
            const VIEW_TYPE_RESULT_FILTER = 'result_filter';

            /**
             * The product ID.
             * Has to be set by the derived classes to either 1 or 2.
             *
             * @var integer
             */
            protected $product_id = 21;

            /**
             * Form object of the module.
             *
             * @var \shared\classes\calculation\client\form
             */
            protected $form = NULL;

            /**
             * Parameter model.
             *
             * @var \shared\classes\calculation\client\model\parameter
             */
            protected $parameter_model = NULL;

            /**
             * The paging model.
             *
             * @var \shared\classes\calculation\client\model\paging
             */
            protected $paging_model = NULL;


            /**
             * Use our own form wrapper class to use the form elements with own template classes
             *
             * @return \classes\calculation\client\form Form object
             */
            protected function create_form_object() {
                return new \shared\classes\calculation\client\form($this->get_client()->get_deviceoutput());
            }

            /**
             * Called in run to define the form.
             *
             * @return \shared\classes\calculation\client\form
             */
            protected function define_form() {

                $_GET['c24_controller'] = 'result';

                $form = $this->create_form_object();

                $form->add_hidden_field('c24_controller', 'result');

                return $form;

            }

            /**
             * Called in run to fill the form after definition.
             *
             * @param \shared\classes\calculation\client\form $form Form.
             * @return void
             */
            protected function fill_form(\shared\classes\calculation\client\form $form) {

                if (count($this->parameters) > 0) {

                    $form->set_data(
                        array_merge(
                            $this->parameters,
                            array('c24_controller' => 'result')
                        )
                    );

                }

            }

            /**
             * Calls the calculation API and returns its response.
             *
             * @throws \rs_logic_exception Exception of product id does not exist
             * @return \shared\classes\calculation\client\response
             */
            protected function get_calculation() {

                if (!product_id_exists($this->get_product_id())) {

                    throw new \rs_logic_exception(
                        'Product ID has to be set in your sub class.'
                    );

                }

                /**
                 * Only if this parameter is set (means that we are comming from Input1),
                 * we send the calculationparameter_id to the calculation server,
                 * else we DON'T send it, because we will NOT receive a new calculation (see BUG PVPKV-2989).
                 * So for example, if the user changes filters, we MUST receive a new calculationparameter_id.
                 * Only if this parameter is set, we send the calculationparameter_id to the calculation server,
                 * else we DON'T send it, because we will NOT receive a new calculation (see BUG PVPKV-2989)
                 */
                if (!isset($this->parameters['c24api_from_input1'])) {
                    unset($this->parameters['c24api_calculationparameter_id']);
                }

                return $this->get_client()->get_calculation(
                    $this->get_product_id(),
                    $this->parameters
                );
            }

            /**
             * Defines the error view.
             *
             * @param \shared\classes\calculation\client\form &$form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_error_view(\shared\classes\calculation\client\form &$form) {

                $error_view = $this->create_view();

                $error_view->filter_position = $this->filter_position;
                $error_view->filter_error = $form->get_error_messages();

                return $error_view;

            }

            /**
             * Defines the paging view for the result view.
             *
             * @param array $paging_data Assoc array containing the data.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_paging_view($paging_data) {

                $paging_view = $this->create_view();

                $this->paging_model = new \shared\classes\calculation\client\model\paging(
                    $paging_data
                );
                $paging_view->paging = $this->paging_model;
                $paging_view->paging->parameter = $this->parameter_model;

                return $paging_view;

            }

            /**
             * Defines the view for one tariff in the result view.
             *
             * @param array $tariff_data         Assoc  array   containing  the
             *                                   data.
             * @param array $evalualation_models An assoc array  of company ids
             *                                   mapping to its eval model.
             * @return \shared\classes\calculation\client\model\resultrowenergy
             */
            protected function define_result_row_model(array $tariff_data, array $evalualation_models) {

                $tariff_view = $this->create_view();

                $class = '\classes\calculation\mclient\model\tariff\\' . get_def('product/' . $this->get_product_id());
                $tariff = new $class($tariff_data);

                $tariff->parameter = $this->parameter_model;
                $evaluation = NULL;

                $subscription_url = '';

                if ($tariff->get_subscription_external() == '') {

                    $subscription_url_parameter = array(
                        'c24api_tariffversion_id' => $tariff->get_tariff_version_id(),
                        'c24api_tariffversion_variation_key' => $tariff->get_tariff_variation_key(),
                        'c24api_product_id' => $tariff->get_tariff_product_id(),
                        'c24api_calculationparameter_id' => $this->parameter_model->get_id(),
                        'signup' => 'yes',
                        'c24_position' => $tariff->get_result_position(),
                        'c24_promotion_type' => $tariff->get_promotion_type(),
                        'c24_is_gold_grade' => $tariff->is_gold_grade(),
                        'deviceoutput' => $this->get_client()->get_deviceoutput()
                    );

                    if ($this->get_client()->get_tracking_id3() == '') {

                        if ($tariff->get_result_position() == 0 && $tariff->get_tariff_promotion() != 'no') {
                            $subscription_url_parameter['tracking_id3'] = '0_' . $tariff->get_provider_name();
                        }

                    }

                    $subscription_url = $this->get_client()->get_link(
                        'register_link',
                        $subscription_url_parameter
                    );

                } else {
                    $subscription_url = $tariff->get_subscription_url();
                }

                return new \shared\classes\calculation\client\model\resultrowenergy($this->create_view(), $tariff, $this->parameter_model, $pricelayer, $subscription_url, $evaluation, $this->campaign_period('shopping_winter_2014'));

            }

            /**
             * Defines the view for one tariff in the result view.
             *
             * @param array $tariff_data         Assoc  array   containing  the
             *                                   data.
             * @param array $evalualation_models An assoc array  of company ids
             *                                   mapping to its eval model.
             * @return \shared\client\view
             */
            protected function define_tariff_view(array $tariff_data, array $evalualation_models) {

                $tariff_view = $this->create_view();

                $class_name = '\classes\calculation\mclient\model\tariff\\' .  get_def('product/' . $this->get_product_id());

                $tariff = new $class_name($tariff_data);

                $tariff_view->tariff = $tariff;
                $tariff_view->tariff->parameter = $this->parameter_model;
                $tariff_view->evaluation = NULL;


                if (isset($evalualation_models[$tariff->get_provider_company_id()])) {

                    $tariff_view->evaluation
                        = $evalualation_models[$tariff->get_provider_company_id()];

                    $tariff_view->link_evaluation_url = $tariff_view->evaluation->get_url(
                        $tariff->get_provider_id(),
                        $this->get_client()->get_partner_id(),
                        $this->get_client()->get_tracking_id(),
                        $this->get_client()->get_tracking_id2(),
                        $this->get_client()->get_tracking_id3(),
                        $this->get_client()->get_tracking_id4(),
                        $this->get_client()->get_mode_id(),
                        $this->get_client()->get_style()
                    );

                }

                $tariff_detail_parameter = array(
                    'c24api_tariffversion_id' => $tariff->get_tariff_version_id(),
                    'c24api_tariffversion_variation_key' => $tariff->get_tariff_variation_key(),
                    'c24api_product_id' => $tariff->get_tariff_product_id(),
                    'c24api_calculationparameter_id' => $this->parameter_model->get_id(),
                    'c24api_birthdate' => $this->parameter_model->get_birthdate(),
                    'c24_position' => $tariff->get_result_position(),
                    'c24_controller' => 'tariff_detail',
                    'deviceoutput'   => $this->get_client()->get_deviceoutput(),
                    'c24_promotion_type' => $tariff->get_promotion_type(),
                    'c24_is_gold_grade' => $tariff->is_gold_grade()
                );

                $tariff_view->tariff_detail_link = $this->getServiceLocator()
                    ->get('ViewHelperManager')
                    ->get('url')
                    ->__invoke('mobile/pkv/tariffdetail', [], ['query' => $tariff_detail_parameter]);

                $tariff_view->parameter = $this->parameter_model;
                $tariff_view->partner_id = $this->get_client()->get_partner_id();
                $tariff_view->tracking_id = $this->get_client()->get_tracking_id();

                $tariff_view->feature = $tariff->get_tariff_feature();

                $data = $this->response->get_data();

                $tariff_view->promotion_count = count($data['promotion']);

                if ($tariff->get_subscription_external() == '') {

                    # parameters are submitted as part of the url and are later stripped by the Zend Framework
                    $tariff_view->subscription_url = $this->get_client()->get_link('register_link') . '11/' . $this->parameter_model->get_id() . '/' . $tariff->get_tariff_version_id() . '/' . $tariff->get_tariff_variation_key();

                } else {
                    $tariff_view->subscription_url = $tariff->get_subscription_external();
                }

                return $tariff_view;

            }

            /**
             * Defines the result view.
             *
             * @param \shared\classes\calculation\client\form $form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_result_view(\shared\classes\calculation\client\form $form) {

                $result_view = $this->create_view();

                $result_view->result_count = 0;

                $result_view->ajax_tariffdetail_link = $this->get_client()->get_link(
                    'ajax/json', array('action' => 'tariffdetail')
                );

                if ($this->get_client()->get_partner_id() >= 360) {
                    $result_view->tariffdetail_overlay = 'yes';
                } else {
                    $result_view->tariffdetail_overlay = 'no';
                }

                if ($this->response->get_status_code() == 400) { // Validation error

                    if ($this->response->get_status_message() == 'Parameter load') {
                        $result_view->form_link = $this->get_client()->get_link('form');
                    } else {

                        $form->set_error(
                            \shared\classes\common\utils::array_prefix(
                                $this->response->get_data(), 'c24api_'
                            )
                        );

                        $error_view = $this->define_error_view($form);

                        if ($form->has_error()) {

                            $result_view->result_content = $error_view->render(
                                'pv/error.php'
                            );

                        } else {

                            $result_view->result_content = $error_view->render(
                                'pv/no_result.php'
                            );

                        }

                    }

                } else if ($this->response->get_status_code() == 200) {

                    $data = $this->response->get_data();

                    // Debug

                    if (isset($data['debug'])) {

                        $result_view->timing = $data['timing'];
                        $result_view->debug = $data['debug'];
                        $result_view->stats = $data['stats'];

                    }

                    // Create api model
                    $this->parameter_model = \classes\calculation\mclient\model\parameter\base::create(
                        $this->get_product_id(),
                        $data['parameter']
                    );

                    $result_view->parameter = $this->parameter_model;

                    // Create evalation models (see the define_tariff_view call below).
                    $evalualation_models = array();

                    /*
                     * Promoted Tariffs logic
                     *
                     * currently it supports only 1 item
                     * -> always the cheapest of the promoted ones
                     */
                    $promo_tariffs = array();
                    $sort_array = [];

                    if (isset($data['promotion'])) {

                        foreach ($data['promotion'] AS $promoted_tariff) {
                            $promo_tariffs[] = $promoted_tariff;
                            $sort_array[$promoted_tariff['tariff']['id']] = $promoted_tariff['result']['promotion_position'];
                        }

                        // Sort tariff IDs by promotion position
                        // and unshift tariffs by tariff ID to result array.
                        // Just use arsort() for reverse order
                        asort($sort_array);

                        foreach ($sort_array AS $tariff_id => $sort_element) {
                            foreach ($promo_tariffs AS $promo_tariff) {
                                if ($promo_tariff['tariff']['id'] == $tariff_id) {
                                    array_unshift($data['result'], $promo_tariff);
                                    break;
                                }
                            }
                        }

                    }


                    /*
                     * Back link
                     */
                    $back_link = '';

                    if (isset($_SERVER['REQUEST_URI'])) {

                        if (mb_strpos($_SERVER['REQUEST_URI'], '?') !== false) {
                            $back_link = mb_substr($_SERVER['REQUEST_URI'], 0, mb_strpos($_SERVER['REQUEST_URI'], '?')) . '?c24_controller=' . urlencode('form');
                        } else {
                            $back_link = $_SERVER['REQUEST_URI'] . '?c24_controller=' . urlencode('form');
                        }

                    }

                    $result_view->back_link = $back_link;


                    /*
                     * RESULT entries
                     * excluding the promoted results
                     */

                    $result_view->result_content = '';

                    if (!empty($data['result'])) {

                        $result_view->compare_link = $this->get_client()->get_link('compare', array('c24api_calculationparameter_id' => $this->parameter_model->get_id()));
                        $result_view->subscription_link = $this->get_client()->get_link('compare', array('c24api_calculationparameter_id' => $this->parameter_model->get_id()));
                        $result_view->result_count = count($data['result']) - count($data['promotion']);

                        while (list($index, $tariff) = each($data['result'])) {

                            $tariff_view = $this->define_tariff_view(
                                $tariff,
                                $evalualation_models
                            );


                            $result_view->result_content .= $tariff_view->render(
                                $this->get_product_key() . '/result_row.php'
                            );

                        }

                    } else {
                        $result_view->result_content = $this->create_view()->render('pv/no_result.php');
                    }

                    // Set data from response

                    $form->set_data(
                        $this->handle_api_parameter(
                            \shared\classes\common\utils::array_prefix($data['parameter'], 'c24api_')
                        )
                    );

                }

                if ($this->parameter_model !== NULL) {
                    $result_view->calculationparameter_id = $this->parameter_model->get_id();
                } else {
                    $result_view->calculationparameter_id = '';
                }

                if (isset($this->paging_model)) {
                    $result_view->current_page = $this->paging_model->get_currentpage();
                }

                $result_view->form = $form;

                return $result_view;

            }

            /**
             * Handle api parameter
             *
             * @param array $data Data
             * @return array
             */
            protected function handle_api_parameter(array $data) {
                return $data;
            }

            /**
             * Defines the reminder view.
             *
             * @param \shared\classes\calculation\client\form $reminder_form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_reminder_view(\shared\classes\calculation\client\form $reminder_form) {

                $reminder_view = $this->create_view();
                $reminder_view->calculationparameter_id = $this->parameter_model->get_id();
                $reminder_view->ajax_reminder_link = $this->get_client()->get_link(
                    'ajax/json', array('action' => 'reminder')
                );

                $reminder_view->form = $reminder_form;

                return $reminder_view;

            }

            /**
             * Defines the head view.
             *
             * @return \shared\classes\calculation\client\view
             */
            protected function define_head_view() {

                $head_view = $this->create_view();

                if ($this->paging_model !== NULL) {
                    $head_view->resultsize = $this->paging_model->get_resultsize();
                } else {
                    $head_view->resultsize = 0;
                }

                if ($this->parameter_model !== NULL) {

                    $head_view->parameter = $this->parameter_model;

                    if ($this->paging_model !== NULL) {
                        $head_view->link_result_pdf = $this->get_client()->get_link('result_pdf', array('c24api_calculationparameter_id' => $this->parameter_model->get_id(), 'c24api_page' => $this->paging_model->get_currentpage()));
                    }

                }

                # $head_view->ajax_fontsize_link = $this->get_client()->get_link('ajax/json', array('action' => 'fontsize'));

                return $head_view;

            }

            /**
             * Defines the header view.
             *
             * @param \shared\classes\calculation\client\form $form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_header_view(\shared\classes\calculation\client\form $form) {

                $header_view = $this->create_view();

                $header_view->tariff_recommended_settings = NULL;
                $header_view->tariff_recommended_settings_paging = NULL;
                $header_view->tariff_cheapest = NULL;
                $header_view->tariff_cheapest_paging = NULL;

                $header_view->form = $form;

                $header_view->partner_id = $this->get_client()->get_partner_id();
                $header_view->tracking_id = $this->get_client()->get_tracking_id();
                $header_view->tracking_id2 = $this->get_client()->get_tracking_id2();
                $header_view->tracking_id3 = $this->get_client()->get_tracking_id3();
                $header_view->tracking_id4 = $this->get_client()->get_tracking_id4();

                if ($this->parameter_model !== NULL) {
                    $header_view->calculationparameter_id = $this->parameter_model->get_id();
                } else {
                    $header_view->calculationparameter_id = '';
                }

                return $header_view;

            }

            /**
             * Defines the footer view.
             *
             * @param string $paging_content The rendered paging view.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_footer_view($paging_content) {

                \shared\classes\common\utils::check_string($paging_content, 'paging_content', true);

                $footer_view = $this->create_view();
                $footer_view->partner_id = $this->get_client()->get_partner_id();
                $footer_view->tracking_id = $this->get_client()->get_tracking_id();
                $footer_view->tracking_id2 = $this->get_client()->get_tracking_id2();
                $footer_view->tracking_id3 = $this->get_client()->get_tracking_id3();
                $footer_view->tracking_id4 = $this->get_client()->get_tracking_id4();
                $footer_view->mode_id = $this->get_client()->get_mode_id();

                if ($this->parameter_model !== NULL) {

                    $footer_view->generaltracking_pixel = \shared\classes\calculation\client\controller\helper\generaltracking::run(
                        $this,
                        $this->get_product_id(),
                        'vergleichsergebnis.html',
                        5,
                        crc32($this->parameter_model->get_id())
                    );

                } else {

                    $footer_view->generaltracking_pixel = \shared\classes\calculation\client\controller\helper\generaltracking::run(
                        $this,
                        $this->get_product_id(),
                        'vergleichsergebnis.html',
                        5
                    );

                }

                $footer_view->visit_tracking_pixel = \shared\classes\calculation\client\controller\helper\tracking_visitlog::run(
                    $this,
                    $this->get_product_id()
                );

                $footer_view->paging = $paging_content;
                $footer_view->parameter = $this->parameter_model;

                return $footer_view;

            }

            /**
             * Generates the output assoc array.
             *
             * The key content contains the content to print.
             *
             * @param \shared\classes\calculation\client\view $head_view   Head view.
             * @param \shared\classes\calculation\client\view $header_view Header view.
             * @param \shared\classes\calculation\client\view $result_view Result view.
             * @param \shared\classes\calculation\client\view $footer_view Footer view.
             * @return array
             * @see ::define_head_view
             * @see ::define_header_view
             * @see ::define_result_view
             * @see ::define_footer_view
             */
            protected function generate_output(\shared\classes\calculation\client\view $head_view, \shared\classes\calculation\client\view $header_view, \shared\classes\calculation\client\view $result_view, \shared\classes\calculation\client\view $footer_view) {

                $output = array();

                if ($this->response->get_status_code() == 500) {

                    // Internal Server errors  are handled by showing the error
                    // page, whereas  all other  errors will be  handled by the
                    // form.

                    if ($this->response->get_status_message() == 'Parameter load') {
                        $result_view_file = 'parameter_load_failed.php';
                    } else {
                        $result_view_file = 'error.php';
                    }

                    $output['head'] = '';
                    $output['result'] = $result_view->render($result_view_file);
                    $output['footer'] = '';
                    $output['back_link'] = '';

                } else {

                    $result_view_file = $this->get_view_file(static::VIEW_TYPE_RESULT, $this->get_product_key());

                    $output['head'] = $head_view->render($this->get_view_file(static::VIEW_TYPE_RESULT_HEADER, $this->get_product_key()));
                    $output['result'] = $result_view->render($result_view_file);
                    $output['footer'] = $footer_view->render($this->get_view_file(static::VIEW_TYPE_RESULT_FOOTER, $this->get_product_key()));
                    $output['back_link'] = isset($result_view->back_link) ? $result_view->back_link : '';
                    $output['filter'] = ''; //$header_view->render($this->get_view_file(static::VIEW_TYPE_RESULT_FILTER, $this->get_product_key()));

                }

                return $output;

            }

            /**
             * Get view file
             *
             * @param string $type Type
             * @param string $product_key Product key
             * @return string
             */
            protected function get_view_file($type, $product_key) {

                switch ($type) {

                    case static::VIEW_TYPE_RESULT :
                    case static::VIEW_TYPE_RESULT_HEADER :
                    case static::VIEW_TYPE_RESULT_FOOTER :
                    case static::VIEW_TYPE_RESULT_FILTER :
                        return $product_key . '/' . $type . '.php';

                }

            }

            /**
             * Handle form data
             *
             * Prepair data before sending to api
             *
             * @param array $data Data
             * @return array
             */
            protected function handle_form_data(array $data) {

                if (isset($data['c24api_considerdiscounts']) && $data['c24api_considerdiscounts'] == 'no') {
                    $data['c24api_maxbonusshare'] = 'no';
                }

                if (isset($data['c24api_companyevaluation_positive'])) {

                    if ($data['c24api_companyevaluation_positive'] == 'yes') {
                        $data['c24api_subscriptiononly'] = 'yes';
                    } else {
                        $data['c24api_subscriptiononly'] = 'no';
                    }

                }

                return $data;

            }

            public function set_state_object() {

            }

            public function get_state_object() {

            }

            /**
             * Runs the module :)
             *
             * @return \shared\classes\calculation\client\controllerstatus
             */
            final public function run() {

                \shared\classes\common\timer::start('define form');
                $this->form = $this->define_form();
                \shared\classes\common\timer::stop('define form');

                \shared\classes\common\timer::start('fill form');

                $this->fill_form($this->form);
                \shared\classes\common\timer::stop('fill form');

                \shared\classes\common\timer::start('get calculation');

                $session = $this->getServiceLocator()->get('SessionContainer');

                // check if calculation data is already in session, in order to avoid a new API request
                if ($session->offsetExists('calculation_data') && $session->offsetGet('calculation_data')) {
                    $this->response = $session->offsetGet('calculation_data');
                    $session->offsetUnset('calculation_data');
                }

                if ($this->response === NULL) { // Direct result jumpin
                    $this->response = $this->get_calculation();
                }

                // We need to update the calculationparameter_id hidden field value with the received on
                $this->get_form()->set_field_value('c24api_calculationparameter_id', htmlspecialchars($this->response->get_data()['parameter']['id']));

                $controllerstatus = $this->handle_response($this->response);

                if ($controllerstatus !== NULL) {
                    return $controllerstatus;
                }

                \shared\classes\common\timer::stop('get calculation');

                \shared\classes\common\timer::start('define views');

                // TODO @temporary: Remove this after we determine what is causing the white screen in PVPKV-2085 and PVPKV-2084
                if ($this->response->get_status_code() != 200) {
                    $this->getServiceLocator()->get('Logger')
                        ->debug(
                            'Error in API response: ' . $this->response->get_status_message() . PHP_EOL . PHP_EOL .
                            'Request data: ' . var_export($this->form->get_data(), true)
                        );
                }

                $result_view = $this->define_result_view($this->get_form());
                $header_view = $this->define_header_view($this->get_form());

                $result_view->result_filter_content = $header_view->render($this->get_view_file(static::VIEW_TYPE_RESULT_FILTER, $this->get_product_key()));

                $result_view->result_headline_visible = true;

                $paging_content = isset($result_view->paging_content)
                    ? $result_view->paging_content
                    : '';

                $output = $this->generate_output(
                    $this->define_head_view(),
                    $header_view,
                    $result_view,
                    $this->define_footer_view($paging_content)
                );

                \shared\classes\common\timer::stop('define views');

                $status = NULL;

                if ($this->response->get_status_code() != 200) {
                    $status = \shared\classes\calculation\client\controllerstatus::FORM_ERROR;
                } else {
                    $status = \shared\classes\calculation\client\controllerstatus::FORM_SUCCESS;
                }

                return new \shared\classes\calculation\client\controllerstatus(
                    $status, $output, $this->response
                );

            }

            // --- GETTER ---

            /**
             * Gets the form of the module.
             *
             * @return \shared\classes\calculation\client\form
             */
            public function get_form() {
                return $this->form;
            }

            /**
             * Returns the ID of the product.
             *
             * @return integer Either 0 for not set, 1 for power or 2 for gas.
             */
            public function get_product_id() {
                return $this->product_id;
            }

            /**
             * Return product key.
             *
             * @throws \exception If key not found
             * @return string
             */
            public function get_product_key() {
                return get_def('products/' . $this->get_product_id() . '/key');
            }

            /**
             * Get random tariffs from promo tariffs but give stromio tariffs more weight while
             * shuffling
             *
             * @param array   $promo_array      Promo array
             * @param integer $max_promotariffs Maximum number of returned promo tariffs
             *
             * @return array                    Promo tariffs
             */
            private function get_random_promo_tariffs(array $promo_array, $max_promotariffs) {

                \shared\classes\common\utils::check_int($max_promotariffs, 'max_promotariffs');

                // Get weighted promo tariffs only if we have more than max tariffs allowed

                $tariffs = [];

                if (count($promo_array) > $max_promotariffs) {

                    if ($this->parameter_model->get_considerdiscounts() == 'no') {

                        // Get the weight of elements only if discounts is unwanted

                        $weighted_array = [];

                        foreach ($promo_array AS $key => $data) {

                            if ($data['provider']['id'] == 10855) {
                                $weighted_array[$key] = 3; // 1.5 times more than the others
                            } else {
                                $weighted_array[$key] = 2;
                            }

                        }

                        // Select elementy by weighted array

                        $tariff_keys = $this->get_multiple_random_tariffs(
                            $weighted_array,
                            $max_promotariffs
                        );

                        // Get tariffs to display

                        $tariffs = [];

                        foreach ($tariff_keys AS $key => $v) {
                            $tariffs[] = $promo_array[$key];
                        }

                    } else {

                        // If we consider discounts, we shuffle them and take 2 tariffs

                        shuffle($promo_array);
                        return array_values(array_slice($promo_array, 0, $max_promotariffs));

                    }

                } else {
                    $tariffs = array_values($promo_array);
                }

                // Shuffle tariffs

                shuffle($tariffs);

                return $tariffs;

            }

            /**
             * Get a single random element from an array.
             *
             * Array has to look like this:
             *
             * ['A' => 3, 'B' => 2, 'C' => 2]
             *
             * This means that you want A to have more weight than B or C.
             *
             * @param array $weighted_array Weighted array
             *
             * @return mixed                Key of element
             */
            private function get_random_weighted_element(array $weighted_array) {

                $rand = mt_rand(1, (int) array_sum($weighted_array));

                foreach ($weighted_array AS $key => $value) {

                    $rand -= $value;

                    if ($rand <= 0) {
                        return $key;
                    }

                }

            }

            /**
             * Get multiple random tariffs with the weighted array
             *
             * For weighted array description see get_random_weighted_element()
             *
             * @param array   $weighted_array Weighted array
             * @param integer $max            Maxmum number of keys from array
             *
             * @return array                  Keys of selected elements
             */
            private function get_multiple_random_tariffs(array $weighted_array, $max) {

                \shared\classes\common\utils::check_int($max, 'max');

                $results = [];

                if (count($weighted_array) <= $max) {
                    return $weighted_array;
                }

                // Start a count for security

                $i = 0;

                while ($i <= 100) {

                    $random_key = $this->get_random_weighted_element($weighted_array);

                    if (!isset($results[$random_key])) {
                        $results[$random_key] = true;
                    }

                    if (count($results) == $max) {
                        break;
                    }

                    $i++;

                }

                return $results;

            }

            /**
             * Is campaign active
             *
             * @param string $campaign Campaign name
             * @return boolean
             */
            public function campaign_period($campaign) {
                return false;
            }

        }

    }
