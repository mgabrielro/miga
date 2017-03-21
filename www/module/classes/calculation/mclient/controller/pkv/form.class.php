<?php
    namespace classes\calculation\mclient\controller\pkv {

        use Common\Validator\Check;
        use shared\classes\common\rs_rest_client\rs_rest_client;

        /**
         * PKV form
         *
         * @author Igor Duspara
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class form extends \shared\classes\calculation\client\controller\base {

            const MAX_CHILDREN_AGE = 21;

            private $price_calc_params = [];

            /**
             * Get product id
             *
             * @return integer
             */
            public function get_product_id() {
                return get_def('product_id');
            }

            /**
             * Create the form object
             *
             * Use you own form object in child classes.
             *
             * @return \classes\calculation\mclient\form Form object
             */
            protected function create_form_object() {
                return $this->getServiceLocator()->get('classes\calculation\mclient\form');
            }

            /**
             * Create a form object and add fields
             *
             * @return \shared\classes\calculation\client\form
             */
            protected function handle_form() {

                $this->price_calc_params = $this->getServiceLocator()
                    ->get(\Common\Provider\PriceCalculationParameter::class)->fetch(date('Y'));

                $c24login_user_birthday = '';

                $c24login_user_birthday_day = '';
                $c24login_user_birthday_month = '';
                $c24login_user_birthday_year = '';

                if ($user_data = $this->getServiceLocator()->get('C24Login')->get_user_data()) {
                    if (isset($user_data['birthday'])) {

                        $user_birthday_ts = strtotime($user_data['birthday']);

                        $c24login_user_birthday = date('d.m.Y', $user_birthday_ts);

                        $c24login_user_birthday_day = date('d', $user_birthday_ts);
                        $c24login_user_birthday_month = date('m', $user_birthday_ts);
                        $c24login_user_birthday_year = date('Y', $user_birthday_ts);
                    }
                }

                $tariff_list = $this->get_provider_list();
                $tariff_list = [0 => 'Bitte wählen'] + $tariff_list;
                $tariff_list2 = [0 => 'Nicht PKV versichert'] + $tariff_list;
                $children_ages = [-1 => 'Bitte wählen'] + $this->get_children_ages_array();

                $form = $this->create_form_object();

                $form->set_state(
                    \classes\filter\abstract_profession_person_state::factory(
                        isset($this->parameters['c24api_profession'])     ? $this->parameters['c24api_profession']     : '',
                        isset($this->parameters['c24api_insured_person']) ? $this->parameters['c24api_insured_person'] : ''
                    )
                );

                $form->add_hidden_field('c24_controller', 'form');
                $form->add_hidden_field('c24_calculate', 'x');
                $form->add_hidden_field('c24api_calculationparameter_id', '');
                $form->add_hidden_field('c24api_rs_lang', '');
                $form->add_hidden_field('c24api_paymentperiod', 'month');
                $form->add_hidden_field('c24api_rs_session', '');

                // PKV fields

                // if is December must remain December, else next month as default
                if(date('m') == 12) {
                    $form->add_hidden_field('c24api_insure_date', date('Y-m-01', time()));
                } else {
                    $form->add_hidden_field('c24api_insure_date', date('Y-m-01', strtotime('+1 month')));
                }

                $form->add_select_field('c24api_profession', $this->get_profession_list(), '');
                $form->add_select_field('c24api_contribution_carrier', $this->get_contribution_carrier_list(), '');
                $form->add_select_field('c24api_contribution_rate', $this->get_contribution_rate_list(), '');
                $form->add_select_field('c24api_children_age', $children_ages, '');
                $form->add_select_field('c24api_parent1_insured', $tariff_list, '');
                $form->add_select_field('c24api_parent2_insured', $tariff_list2, '' );

                $form->add_radio_list('c24api_insured_person', ['adult' => 'Erwachsener', 'child'  => 'Kind'], 'adult');
                $form->add_radio_list('c24api_parent_servant_or_servant_candidate', ['no' => 'nein', 'yes'  => 'ja'], 'no');
                $form->add_date_field('c24api_birthdate', $c24login_user_birthday);

                $form->add_text_field('c24api_birthdate_day', $c24login_user_birthday_day);
                $form->add_text_field('c24api_birthdate_month', $c24login_user_birthday_month);
                $form->add_text_field('c24api_birthdate_year', $c24login_user_birthday_year);

                $form->add_hidden_field('c24api_pdhospital_payout_amount_value', '100');
                $form->add_hidden_field('c24api_pdhospital_payout_start', '43');

                $form->add_select_field('c24api_provision_costsharing_limit', $this->get_provision_costsharing_limit(), $form->get_state()
                    ->getDefaultProvisionCostsharingLimit());

                $form->add_radio_list('c24api_hospitalization_accommodation', $form->get_state()->getAccomondationOptions(), $form->get_state()
                    ->getDefaultHospitalizationAccommodation());

                $form->add_radio_list('c24api_dental', $this->get_dental_list(), $form->get_state()
                    ->getDefaultDental());

                return $form;

            }

            /**
             * Get the provision costsharing limit list ("Selbstbeteiligung")
             *
             * @return array
             */
            public function get_provision_costsharing_limit() {

                return [
                        '350' => 'max. 350 €',
                        '650' => 'max. 650 €',
                        '1000' => 'max. 1.000 €'
                ];

            }

            /**
             * Get the Dental list
             *
             * @return array
             */
            public function get_dental_list() {

                return [
                    'basic'   => 'Basis',
                    'comfort' => 'Komfort',
                    'premium' => 'Premium'
                ];

            }

            /**
             * Get the accomodation list
             *
             * @return array
             */
            public function get_accomondation_list() {

                return [
                    'multi' => 'Mehrbettzimmer',
                    'double' => '2-Bett-Zimmer/Chefarzt',
                    'single' => '1-Bett-Zimmer/Chefarzt'
                ];

            }

            /**
             * Handle form data and set fallback values for form fields that weren't submitted
             *
             * @param array $data Form data
             *
             * @return array
             */
            protected function handle_form_data(array $data) {
                return $data;
            }

            /**
             * Request to rest client to find out, if we have currently a special action available
             *
             * @throws \shared\classes\common\rs_rest_client\rs_rest_client_exception Rest client exception
             * @return boolean
             */
            protected function has_special_action() {

                $rest_client = $this->get_client()->rest_client();
                $response = $rest_client->send_request(\shared\classes\common\rs_rest_client\rs_rest_client::METHOD_GET, 'tariff_action');

                $has_special_action = isset($response['data']['special_action']) && (bool) $response['data']['special_action'];
                return $has_special_action;

            }

            /**
             * Run
             *
             * @return \shared\classes\calculation\client\controllerstatus
             */
            public function run() {

                $form = $this->handle_form();

                $status = NULL;
                $response = NULL;

                if (isset($this->parameters['c24_calculate']) || isset($this->parameters['c24_change_options'])) {

                    $data = $this->parameters;

                    $exclude_parameters = ['c24_calculate', 'c24_change_options'];

                    for ($i = 0, $max = count($exclude_parameters); $i < $max; ++$i) {

                        if (isset($data[$exclude_parameters[$i]])) {
                            unset($data[$exclude_parameters[$i]]);
                        }

                    }

                    $form->set_data($data);

                    // Validate data with api request
                    $response = $this->get_client()->get_calculation(
                        $this->get_product_id(),
                        $this->handle_form_data($form->get_data())
                    );

                    $controllerstatus = $this->handle_response($response);

                    if ($controllerstatus !== NULL) {
                        return $controllerstatus;
                    } else if ($response->get_status_code() === 400) {
                        $form->set_error(\shared\classes\common\utils::array_prefix($response->get_data(), 'c24api_'));
                        $status = \shared\classes\calculation\client\controllerstatus::FORM_ERROR;
                    } else {

                        $status = \shared\classes\calculation\client\controllerstatus::FORM_SUCCESS;

                        // save the calculation data in session, in order to avoid a second request from the result controller
                        $session = $this->getServiceLocator()->get('SessionContainer');
                        $session->offsetSet('calculation_data', $response);
                        
                    }

                } else if (count($this->parameters) > 0) {
                    $form->set_data($this->parameters);
                    $status = \shared\classes\calculation\client\controllerstatus::SUCCESS;
                } else {
                    $status = \shared\classes\calculation\client\controllerstatus::SUCCESS;
                }

                $view = $this->create_view();
                $this->render_login_view($view);

                if (isset($this->parameters['c24_change_options']) && isset($status) && $status == \shared\classes\calculation\client\controllerstatus::FORM_SUCCESS) {
                    $view->is_input2 = true;
                    $form->set_data(array_prefix('c24api_', $response->get_data('parameter')));
                }

                $view->has_special_action = false;
                $view->form = $form;
                $view->ajax_cities_link = $this->get_client()->get_link('ajax/json', array('action' => 'cities'));
                $view->ajax_reference_tariff_link = $this->get_client()->get_link('ajax/json', array('action' => 'calculation'));
                $view->partner_id = $this->get_client()->get_partner_id();
                $view->tracking_id = $this->get_client()->get_tracking_id();
                $view->tracking_id2 = $this->get_client()->get_tracking_id2();
                $view->tracking_id3 = $this->get_client()->get_tracking_id3();
                $view->tracking_id4 = $this->get_client()->get_tracking_id4();
                $view->mode_id = $this->get_client()->get_mode_id();
                $view->is_android_mobile_device = $this->is_android_mobile_device();
                $view->price_calc_params = $this->price_calc_params;

                $view->generaltracking_pixel = \shared\classes\calculation\client\controller\helper\generaltracking::run($this, 1, 'formular.html');

                return new \shared\classes\calculation\client\controllerstatus($status, $view->render('default/pkv/form.php'), $response);

            }

            /**
             * Detect if is an Android device in use
             */
            protected function is_android_mobile_device() {

                $ua = strtolower($_SERVER['HTTP_USER_AGENT']);

                return (stripos($ua,'android') !== false && (stripos($ua,'mobile') !== false));

            }

            /**
             * Renders the login view
             *
             * @param \shared\classes\calculation\client\view $view The main view
             * @return void
             */
            private function render_login_view($view) {

                $c24login_view = $this->create_view();
                $c24login_view->ajax_c24login_login_link = $this->get_client()
                    ->get_link('ajax/json', array('action' => 'c24login_login'));
                $c24login_view->ajax_c24login_logout_link = $this->get_client()
                    ->get_link('ajax/json', array('action' => 'c24login_logout'));
                $c24login_view->ajax_c24login_loginreminder_link = $this->get_client()
                    ->get_link('ajax/json', array('action' => 'c24login_reminder'));

                if (function_exists('is_check24') && is_check24($this->get_client()
                        ->get_partner_id(), $this->get_client()->get_tracking_id())
                ) {

                    if (!empty($_COOKIE['c24session'])) {

                        $c24login = new \myc24login();

                        $c24login->autologin_session($_COOKIE['c24session']);

                        if ($c24login->is_authed() == true) {

                            $user_data = $c24login->get_user_data();
                            $view->c24login_username = $user_data['email'];

                        } else {
                            $view->c24login_username = '';
                            $c24login_view->prefill_email = $c24login->get_user_email();
                        }

                    } else {
                        $view->c24login_username = '';
                    }

                    $view->c24login = $c24login_view->render('c24login.php');

                }

            }

            /**
             * Get profession list
             *
             * @return array
             */
            protected function get_profession_list() {

                $employee = 'Angestellter';

                if (! empty($this->price_calc_params['income_threshold_amount'])) {
                    $helper = $this->getServiceLocator()->get('ViewHelperManager')->get('currencyformat');
                    $employee = 'Angestellter (ab ' . $helper($this->price_calc_params['income_threshold_amount'], null, false). ' p.a.)';
                }

                $profession_list = [
                    ''                  => 'Bitte wählen',
                    'employee'          => $employee,
                    'freelancer'        => 'Selbständiger/Freiberufler',
                    'servant'           => 'Beamter',
                    'servant_candidate' => 'Beamtenanwärter',
                    'student'           => 'Student',
                    'unemployed'        => 'Nicht erwerbstätig',
                ];

                return $profession_list;

            }

            /**
             * Get contribution carrier list
             *
             * @return array
             */
            public function get_contribution_carrier_list() {

                return [
                    '' => ' Bitte wählen',
                    'association' => 'Bund',
                    'bw' => 'Baden-Württemberg',
                    'by' => 'Bayern',
                    'be' => 'Berlin',
                    'bb' => 'Brandenburg',
                    'hb' => 'Bremen',
                    'hh' => 'Hamburg',
                    'he' => 'Hessen',
                    'mv' => 'Mecklenburg-Vorpommern',
                    'ni' => 'Niedersachsen',
                    'nw' => 'Nordrhein-Westfalen',
                    'rp' => 'Rheinland-Pfalz',
                    'sl' => 'Saarland',
                    'sn' => 'Sachsen',
                    'st' => 'Sachsen-Anhalt',
                    'sh' => 'Schleswig-Holstein',
                    'th' => 'Thüringen'
                ];

            }

            /**
             * Get contribution rate list
             *
             * @return array
             */
            public function get_contribution_rate_list() {

                return [
                    '' => ' Bitte wählen',
                    '45' => '45%',
                    '50' => '50%',
                    '55' => '55%',
                    '60' => '60%',
                    '65' => '65%',
                    '70' => '70%',
                    '75' => '75%',
                    '80' => '80%',
                ];

            }

            /**
             * Get child ages. Possible values from 0 to 21.
             *
             * @return array
             */
            public function get_children_ages_array() {

                $children_ages = [];

                for ($i = 0; $i <= self::MAX_CHILDREN_AGE; $i++) {
                    $children_ages[$i] = $i;
                }

                return $children_ages;

            }

            /**
             * Get available providers from desktop API.
             *
             * @return array
             */
            public function get_provider_list() {

                $provider_list = [];

                /* @var $client \shared\classes\common\rs_rest_client\rs_rest_client */
                $client = $this->getServiceLocator()->get('shared\classes\common\rs_rest_client\rs_rest_client');

                try {

                    $response = $client->send_request(\shared\classes\common\rs_rest_client\rs_rest_client::METHOD_GET, 'mobile/provider_list');

                    if (isset($response['data']) && is_array($response['data'])) {
                        $provider_list = $response['data'];
                    }

                } catch (rs_rest_client_exception $exception) {
                    return $provider_list;
                }

                return $provider_list;

            }

        }

    }
