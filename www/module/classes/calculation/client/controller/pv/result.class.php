<?php

    namespace classes\calculation\client\controller\pv;

    use classes\calculation\client\model\backdating;
    use shared\classes\calculation\client\model\tariff;
    use shared\classes\calculation\client\response;
    use \shared\classes\common\exception;
    use \shared\classes\calculation\client\controllerstatus;
    use classes\calculation\client\model\insurance_starting_dates;

    /**
     *  Result
     *
     * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
     * @author Robert Curth <robert.curth@check24.de>
     */
    abstract class result extends \shared\classes\calculation\client\controller\result {

        const VIEW_TYPE_RESULT = 'result';
        const VIEW_TYPE_RESULT_HEADER = 'result_head';
        const VIEW_TYPE_RESULT_FOOTER = 'result_footer';
        const VIEW_TYPE_RESULT_FILTER = 'result_filter';

        /**
         * @var ServiceLocatorInterface
         */
        protected $serviceLocator = NULL;

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
         * the price range for topbar
         *
         * @var array
         */
        protected $price_range = [];

        /**
         * Second response if we found a cheaper insurance date for the user
         *
         * @var shared_client\response
         */
        protected $backdated_response = NULL;

        /**
         * backdating helper
         *
         * @var backdating
         */
        protected $backdating = NULL;

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

                // Remove thousand seperator

                if (isset($this->parameters['c24api_insure_sum']) && $this->parameters['c24api_insure_sum'] != '') {
                    $this->parameters['c24api_insure_sum'] = str_replace('.', '', $this->parameters['c24api_insure_sum']);
                }

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
         * @param string $insure_date The insure date defaults to NULL, i.e.
         *                            the calculation server calculates the
         *                            date itself. If we pass an insure date
         *                            here, we override the calculation server
         *                            to force a specific date of insurance.
         * @return shared_client\response
         */
        protected function call_calculation_api($insure_date = NULL) {

            if (!isset($insure_date)) {
                $insure_date = (new \DateTime)->modify('first day of next month')->format('Y-m-d');
            }

            $this->parameters['c24api_insure_date'] = $insure_date;

            if (isset($this->parameters['c24_debug']) &&
                $this->parameters['c24_debug'] == 'yes'
            ) {
                $this->get_client()->set_debug('yes');
            }

            if (isset($this->parameters['c24_caching']) &&
                $this->parameters['c24_caching'] == 'no'
            ) {
                $this->get_client()->set_caching('no');
            }

            if (isset($this->parameters['create_new_calculationparameter_id'])) {
                $this->parameters['c24api_create_new_calculationparameter_id'] = $this->parameters['create_new_calculationparameter_id'];
            }

            $response = $this->get_client()->get_calculation(
                $this->get_product_id(),
                $this->parameters
            );

            $this->set_parameter_model($response);

            return $response;

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
         * Defines the view for one tariff in the result view.
         *
         * @param array $tariff_data Tariff data
         * @param mixed $backdated_tariff_data The backdated version of the tariff
         * @param array $evalualation_models An assoc array  of company ids
         *                                   mapping to its eval model.
         * @return \shared\client\view
         */
        protected function define_tariff_view(array $tariff_data, $backdated_tariff_data, array $evalualation_models) {

            $tariff_view = $this->create_view();

            $class_name = '\classes\calculation\client\model\tariff\\' .  get_def('product/' . $this->get_product_id());

            if ($backdated_tariff_data) {

                $tariff = new $class_name($backdated_tariff_data);
                $secondary_tariff = new $class_name($tariff_data);
                $tariff_view->tariff = $tariff;
                $tariff_view->secondary_tariff = $secondary_tariff;

            } else {

                $tariff = new $class_name($tariff_data);
                $tariff_view->tariff = $tariff;

            }

            $tariff_view->backdating = $this->get_backdating();


            $tariff_view->tariff->parameter = $this->parameter_model;
            $tariff_view->evaluation = NULL;
            $this->price_range[] = $tariff->get_paymentperiod_size();

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
                'c24_position' => $tariff->get_result_position()
            );

            $tariff_view->tariff_detail_link = $this->get_client()->get_link(
                'tariff_detail',
                $tariff_detail_parameter
            );

            $tariff_view->compare_link = $this->get_client()->get_link('compare', array('c24api_calculationparameter_id' => $this->parameter_model->get_id()));

            $tariff_view->parameter = $this->parameter_model;
            $tariff_view->partner_id = $this->get_client()->get_partner_id();
            $tariff_view->tracking_id = $this->get_client()->get_tracking_id();

            $data = $this->response->get_data();

            if ($tariff->get_subscription_external() == '') {

                # parameters are submitted as part of the url and are later stripped by the Zend Framework
                $tariff_view->subscription_url = $this->get_zend_url_plugin()->fromRoute('desktop/pkv/register_create', array(
                    'product_id'                  => $this->get_product_id(),
                    'calculationparameter_id'     => $this->parameter_model->get_id(),
                    'tariffversion_id'            => $tariff->get_tariff_version_id(),
                    'tariffversion_variation_key' => $tariff->get_tariff_variation_key()
                ));

            } else {
                $tariff_view->subscription_url = $tariff->get_subscription_external();
            }



            $promo_tariff = ($tariff->get_result_position() == 0 && $tariff->get_tariff_promotion() != 'no');

            $tariff_promotion_title = '';
            $tariff_promotion_text = '';

            if ($tariff->get_tariff_promotion()) {
                $tariff_promotion_title = $tariff->get_tariff_promotion_title();
            }

            if ($tariff->get_tariff_tips()) {
                $tariff_promotion_text = $tariff->get_tariff_tips_as_string();
            }


            $tariff_button = new \classes\calculation\client\controller\helper\request_offer_button($tariff_view);

            $tariff_button->set_css_class('row-column column_action');
            $tariff_button->set_tariff($tariff);
            $tariff_button->set_subscription_url($tariff_view->subscription_url);

            $tariff_view->tariff_variation_key = $tariff->get_tariff_version_id() . '-' . $tariff->get_tariff_variation_key();
            $tariff_view->promo_tariff = $promo_tariff;
            $tariff_view->tariff_features = $tariff->get_tariff_feature();
            $tariff_view->tariff_promotion_title = $tariff_promotion_title;
            $tariff_view->tariff_promotion_text = $tariff_promotion_text;
            $tariff_view->tariffdetails_html = $tariff_view->render('default/helper/tariffdetails.php');
            $tariff_view->pointplan_helper = $this->getServiceLocator()->get('ViewHelperManager')->get('pointplan');
            $tariff_view->request_offer_button = $tariff_button->get_output();


            /**
             * assign variables
             */
            $tariff_view->product_id  = $this->get_product_id();
            $tariff_view->product_key = $this->get_product_api_name();

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



            $result_view->compare_link = '';
            $result_view->subscription_link = '';
            $result_view->result_count = 0;



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
                        $result_view->result_content = $error_view->render('pv/error.php');
                    } else {
                        $result_view->result_content = $error_view->render('pv/no_result.php');
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



                $result_view->parameter = $this->parameter_model;


                // Create evalation models (see the define_tariff_view call
                // below).

                $evalualation_models = [];

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
                    $result_view->result_count = count($data['result']);

                }


                $result_view->result_content = $this->render_results($data, $evalualation_models);

                // Set data from response

                $form->set_data(
                    $this->handle_api_parameter(
                        \shared\classes\common\utils::array_prefix($data['parameter'], 'c24api_')
                    )
                );

            }

            $result_view->form = $form;

            if(isset($data) && count($data['result']) && isset($this->price_range) && is_array($this->price_range))
            {

                $this->getServiceLocator()
                    ->get('ViewHelperManager')
                    ->get('topbar')
                    ->setTemplatePath('application/helper/topbar_result.phtml')
                    ->setData([
                        'count'     => $result_view->result_count,
                        'min_price' => min($this->price_range),
                        'max_price' => max($this->price_range),
                        'payment_period' => $form->get_options('c24api_paymentperiod')[$form->get_data()['c24api_paymentperiod']]
                    ]);

            }



            $result_view->backdating = $this->get_backdating();

            return $result_view;

        }

        /**
         * Returns the Product API name.
         *
         * @return string
         */
        public function get_product_api_name() {
            return get_def('product/' . $this->get_product_id());
        }

        /**
         * Renders all the tariff results
         *
         * @param array $response Response
         * @param array $evalualation_models Evaluation Models
         *
         * @return string
         */
        private function render_results($response, $evalualation_models) {

            $response = $this->prepend_promotions($response);

            $results = $response['result'];

            if (empty($results)) {
                return $this->create_view()->render('pv/no_result.php');
            }


            if ($this->get_backdated_response()) {

                $backdated_data = $this->get_backdated_response()->get_data();
                $backdated_data = $this->prepend_promotions($backdated_data);
                $backdated_results = $backdated_data['result'];

            }

            $rendered_results = '<div id="tariff_compare">';

            while (list($index, $tariff) = each($results)) {
                $backdated_tariff = isset($backdated_results[$index]) ? $backdated_results[$index] : $tariff;
                $rendered_results .= $this->render_result($tariff, $backdated_tariff, $evalualation_models);
            }

            $rendered_results .= '</div>';

            return $rendered_results;

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

            $head_view->resultsize = 0;

            if ($this->parameter_model !== NULL) {
                $head_view->parameter = $this->parameter_model;
            }

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
         * Runs the module :)
         *
         * @return \shared\classes\calculation\client\\shared\classes\calculation\client\controllerstatus
         */
        final public function run() {

            $this->form = $this->define_form();
            $this->fill_form($this->form);

            if (empty($this->response)) {
                $this->response = $this->call_calculation_api(NULL);
            } else {
                $this->set_parameter_model($this->response);
            }

            if ($this->get_backdating()->is_active()){
                $backdated_date = $this->get_backdating()->get_backdated_date();
                $this->backdated_response = $this->call_calculation_api($backdated_date->format('Y-m-d'));
            }

            $controllerstatus = $this->handle_response($this->response);

            if ($controllerstatus !== NULL) {
                return $controllerstatus;
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

            $status = NULL;

            if ($this->response->get_status_code() != 200) {
                $status = controllerstatus::FORM_ERROR;
            } else {
                $status = controllerstatus::FORM_SUCCESS;
            }

            return new controllerstatus($status, $output, $this->response);

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
         * Returns the optimal insure date
         *
         * @return backdating
         */
        public function get_backdating() {

            if (!$this->backdating){

                $birth_date = $this->parameter_model->get_data()['birthdate'];
                $insure_dates = new insurance_starting_dates($birth_date);
                $this->backdating = new backdating($insure_dates, !$this->is_backdating_disabled_by_user());

            }

            return $this->backdating;

        }

        /**
         * Checks if backdating is disabled by user
         *
         * @return boolean
         */
        private function is_backdating_disabled_by_user() {
            return isset($this->parameters['c24api_allow_backdating']) &&  $this->parameters['c24api_allow_backdating'] == 'no';
        }


        /**
         * Returns the backdated results
         *
         * @return shared_client\response
         */
        public function get_backdated_response() {
            return $this->backdated_response;
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
         * Is campaign active
         *
         * @param string $campaign Campaign name
         * @return boolean
         */
        public function campaign_period($campaign) {
            return false;
        }

        /**
         * Renders one row of the result list
         *
         * @param array $tariff Tariff
         * @param mixed $backdated_tariff Backdated Tariff
         * @param mixed $evalualation_models Evaluation Model
         *
         * @return mixed
         */
        private function render_result($tariff, $backdated_tariff, $evalualation_models) {

            $tariff_view = $this->define_tariff_view($tariff, $backdated_tariff, $evalualation_models);

            $rendered_result = $tariff_view->render($this->get_product_key() . '/result_row.php');
            return $rendered_result;

        }

        /**
         * Prepends promotions to the result
         *
         * @param array $response Response
         *
         * @return array Modified response
         */
        protected function prepend_promotions(array $response) {

            if (empty($response['result'])) {
                return $response;
            }

            if (!empty($response['promotion']) && $response['paging']['currentpage'] == 1) {

                $shuffled_indizes = array_keys($response['promotion']);
                shuffle($shuffled_indizes);

                for ($i = 0, $n = count($response['promotion']); $i < $n; ++$i) {

                    // We have to reset the promotion position, because of the shuffle
                    $response['promotion'][$i]['result']['promotion_position'] = $n - $i;

                    array_unshift($response['result'], $response['promotion'][$shuffled_indizes[$i]]);

                }

            }

            return $response;

        }



        /**
         * Sets the parameter model
         *
         * @param response $response API Response
         *
         * @return void
         */
        protected function set_parameter_model($response) {
            $this->parameter_model = \classes\calculation\client\model\parameter\base::create($this->get_product_id(), $response->get_data()['parameter']);
        }

    }

