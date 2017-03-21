<?php

    namespace classes\calculation\client\controller\pkv;

    use classes\calculation\client\model\insurance_starting_dates;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    /**
     * PKV form
     *
     * @author Igor Duspara
     * @author Robert Curth <robert.curth@check24.de>
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class form extends \shared\classes\calculation\client\controller\base implements ServiceLocatorAwareInterface {

        protected $serviceLocator = NULL;

        /**
         * Get product id
         *
         * @return integer
         */
        public function get_product_id() {
            return 11;
        }

        /**
         * Create the form object
         *
         * Use you own form object in child classes.
         *
         * @return \shared\classes\calculation\client\form Form object
         */
        protected function create_form_object() {

            return $this->getServiceLocator()->get('classes\calculation\client\form');

        }

        /**
         * Create a form object and add fields
         *
         * @return \shared\classes\calculation\client\form
         */
        protected function handle_form() {

            $c24login_user_birthday = '';

            if ($user_data = $this->getServiceLocator()->get('C24Login')->get_user_data()) {
                if (isset($user_data['birthday'])) {
                    $c24login_user_birthday = date('d.m.Y', strtotime($user_data['birthday']));
                }
            }

            $form = $this->create_form_object();

            $form->add_hidden_field('c24_controller', 'form');
            $form->add_hidden_field('c24_calculate', 'x');
            $form->add_hidden_field('c24api_calculationparameter_id', '');
            $form->add_hidden_field('c24api_rs_lang', '');
            $form->add_hidden_field('c24api_sortfield', 'price');
            $form->add_hidden_field('c24api_sortorder', 'asc');
            $form->add_hidden_field('c24api_occupation_id', '');
            $form->add_hidden_field('c24api_paymentperiod', 'month');
            $form->add_hidden_field('c24api_sum_course', 'decreasing_linearly');
            $form->add_hidden_field('c24api_constant_contribution', 'no');
            $form->add_hidden_field('c24api_allow_backdating', 'yes');

            $form->add_hidden_field('c24api_rs_session', '');

            $form->add_radio_list('c24api_protectiontype', $this->get_protectiontype_options(), 'constant');

            $form->add_text_field('c24api_insure_sum', '100.000');
            $form->add_text_field('c24api_insure_period', '20');
            $form->add_date_field('c24api_birthdate', $c24login_user_birthday);

            $form->add_radio_field('c24api_smoker', 'no');

            $form->add_text_field('c24api_occupation_name', '');


            return $form;

        }

        /**
         * Handle form data and set fallback values for form fields that weren't submitted
         *
         * @param array $data Form data
         *
         * @return array
         */
        protected function handle_form_data(array $data) {
            $data['c24api_insure_date'] = (new \DateTime)->modify('first day of next month')->format('Y-m-d');

            return $data;

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

            if (isset($_GET['c24_calculate'])) {

                $form->set_data($_GET);

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
                }

            } else if (count($this->parameters) > 0) {
                $form->set_data($this->parameters);
                $status = \shared\classes\calculation\client\controllerstatus::SUCCESS;
            } else {
                $status = \shared\classes\calculation\client\controllerstatus::SUCCESS;
            }

            $c24login_view = $this->create_view();

            $c24login_view->ajax_c24login_login_link = $this->get_client()->get_link('ajax/json', array('action' => 'c24login_login'));
            $c24login_view->ajax_c24login_logout_link = $this->get_client()->get_link('ajax/json', array('action' => 'c24login_logout'));
            $c24login_view->ajax_c24login_loginreminder_link = $this->get_client()->get_link('ajax/json', array('action' => 'c24login_reminder'));


            $view = $this->create_view();

            if (function_exists('is_check24') && is_check24($this->get_client()->get_partner_id(), $this->get_client()->get_tracking_id())) {

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

            //TODO: subject of refactoring thema PVPKV-1335
            $view->tariffs = $this->getServiceLocator()->get('participating_tariff')->get_all();

            $view->special_action = $this->getServiceLocator()->get('special_action');
            $view->form = $form;
            $view->ajax_cities_link = $this->get_client()->get_link('ajax/json', array('action' => 'cities'));
            $view->ajax_reference_tariff_link = $this->get_client()->get_link('ajax/json', array('action' => 'calculation'));
            $view->partner_id = $this->get_client()->get_partner_id();
            $view->tracking_id = $this->get_client()->get_tracking_id();
            $view->tracking_id2 = $this->get_client()->get_tracking_id2();
            $view->tracking_id3 = $this->get_client()->get_tracking_id3();
            $view->tracking_id4 = $this->get_client()->get_tracking_id4();
            $view->mode_id = $this->get_client()->get_mode_id();

            $view->parameters = $this->parameters;


            $view->generaltracking_pixel = \shared\classes\calculation\client\controller\helper\generaltracking::run($this, 1, 'formular.html');

            return new \shared\classes\calculation\client\controllerstatus($status, $view->render('default/pkv/form.php'), $response);

        }


        /**
         * Get protectiontype options
         *
         * @return array
         */
        protected function get_protectiontype_options() {

            return array(
                'constant' => 'Konstante Versicherungssumme<br /><span class="c24-note">(Ideal zur Familienabsicherung)</span>',
                'falling' => 'Fallende Versicherungssumme<br /><span class="c24-note">(Ideal zur Kreditabsicherung)</span>'
            );

        }

        /**
         * Set service locator
         *
         * @param ServiceLocatorInterface $serviceLocator Service Locator
         * @return void
         */
        public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
            $this->serviceLocator = $serviceLocator;
        }

        /**
         * Get service locator
         *
         * @return ServiceLocatorInterface
         */
        public function getServiceLocator() {
            return $this->serviceLocator;
        }

    }
