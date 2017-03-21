<?php

namespace classes\calculation\client\controller\pv;

use \shared\classes\calculation\client\view;
use \shared\classes\calculation\client AS shared_client;
use \shared\classes\calculation\client\controllerstatus;
use \classes\calculation\client\controller\helper;
use \classes\calculation\client\model;
use \classes\calculation\client\model\tariff\base AS tariff_model;

    /**
     * Controller for the pv compare page
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     * @author Robert Eichholtz <robert.eichholtz@check24.de>
     * @author Robert Curth <robert.curth@check24.de>
     */
    abstract class compare extends \shared\classes\calculation\client\controller\base {

        /**
         * @var \shared\classes\calculation\client\view
         */
        protected $view;

        /**
         * @var array
         */
        protected $sections = [];

        /**
         * @var
         */
        protected $calculationparameter = NULL;

        /**
         * Parameter model.
         *
         * @var shared_client\model\parameter
         */
        protected $parameter_model = NULL;

        /**
         * Get product id
         *
         * @return integer
         */
        abstract public function get_product_id();

        /**
         * Returns the Product API name.
         *
         * @return string
         */
        public function get_product_api_name() {
            return get_def('product/' . $this->get_product_id());
        }

        /**
         * Call this on all errors that hinders the page on working correctly.
         *
         * @return controllerstatus
         */
        public function create_form_error_redirect_controllerstatus() {

            $view = $this->create_view();
            $view->link_to = $this->get_client()->get_link('form');

            $output = [
                'head'   => '',
                'result' => $view->render($this->get_product_api_name() . '/compare_redirect.phtml'),
                'filter' => '',
                'footer' => ''
            ];

            return new controllerstatus(controllerstatus::FORM_ERROR, $output);

        }

        /**
         * Return created tariff model from data
         *
         * @param array $tariff_data Tarif data
         *
         * @return \shared\classes\calculation\client\model\tariff
         */
        private function get_tariff_model(array $tariff_data) {

            $tariff = tariff_model::create($this->get_product_id(), $tariff_data);
            $tariff = $this->rebuild_subscription_link($tariff);

            return $tariff;

        }

        /**
         * Rebuild the subscription link for a tariff
         *
         * @param \shared\classes\calculation\client\model\tariff $tariff The tariff
         *
         * @return \shared\classes\calculation\client\model\tariff
         */
        protected function rebuild_subscription_link($tariff) {

            if ($tariff->get_subscription_external() == '') {

                $tariff->subscription_url = $this->get_zend_url_plugin()->fromRoute('desktop/pkv/register_create', array(
                    'product_id'                  => $this->get_product_id(),
                    'calculationparameter_id'     => $this->calculationparameter->get_id(),
                    'tariffversion_id'            => $tariff->get_tariff_version_id(),
                    'tariffversion_variation_key' =>  $tariff->get_tariff_variation_key()
                ));

            } else {
                $tariff->subscription_url = $tariff->get_subscription_external();
            }

            return $tariff;

        }


        /**
         * Runs the controller.
         *
         * @return controllerstatus
         */
        public function run() {
            
            /** @var array $pager_keys the keys where have to be paginated */
            $pager_keys = [];

            /** @var array $comparison array of tariff models to compare */
            $comparison = [];

            /**
             * check if calculation parameter is given
             */

            if (empty($this->parameters['c24api_calculationparameter_id'])) {
                return $this->create_form_error_redirect_controllerstatus();
            }

            /**
             * request to the calculation server to get calculation
             */
            $response = $this->get_client()->get_calculation($this->get_product_id(), [
                'c24api_calculationparameter_id' => $this->parameters['c24api_calculationparameter_id'],
                'c24api_create_new_calculationparameter_id' => $this->create_new_calculationparameter_id(),
                'c24api_pagesize' => 2000
            ]);

            /**
             * check the calculation response status code
             */

            if ($response->get_status_code() != 200) {
                return $this->create_form_error_redirect_controllerstatus();
            }

            /**
             * check the calculation response data
             */
            $response_data = $response->get_data();

            if (empty($response_data['result'])) {
                return $this->create_form_error_redirect_controllerstatus();
            }

            /**
             * grab the selected tariffs to compare
             */
            $selected_tariff_keys = array();

            foreach ([1,2,3] AS $i) {

                if (!empty($this->parameters['c24_tariffversion_key_' . $i])) {
                    $selected_tariff_keys[] = $this->parameters['c24_tariffversion_key_' . $i];
                }

            }

            /** @var array $tariffs the tariffs from calculation server */
            $tariffs = $response_data['result'];

            /**
             * grab calculation parameters
             */
            $this->calculationparameter = model\parameter\base::create($this->get_product_id(), $response_data['parameter']);


            /** set selected tariffs at first */
            
            foreach ($selected_tariff_keys AS $i => $key) {

                if (isset($tariffs[$key])) {
                    $comparison[] = $this->get_tariff_model($tariffs[$key]);
                    unset($tariffs[$key]);
                } else {

                    /**
                     * TODO we should redirect to tariff overview page
                     *
                     * while key should not exists anymore,
                     * following quickfix helps to prevent error page
                     */
                    unset($selected_tariff_keys[$i]);

                }

            }

            /** @var array $selected_tariff_keys reset key index after possible unset */
            $selected_tariff_keys = array_merge($selected_tariff_keys);

            /** append other keys */

            foreach ($tariffs AS $tariff_key => $tariff) {
                $comparison[] = $tariff = $this->get_tariff_model($tariff);
                $pager_keys[] = $tariff->get_tariff_version_id() . '-' . $tariff->get_tariff_variation_key();
            }

            /**
             * create view object
             */
            $this->view = $this->create_view();

            /**
             * assign variables
             */
            $this->view->product_id  = $this->get_product_id();
            $this->view->product_key = $this->get_product_api_name();

            $this->view->pager_keys    = $pager_keys;
            $this->view->selected_keys = $selected_tariff_keys;
            $this->view->selected_keys_count = count($selected_tariff_keys);
            $this->view->sections   = $this->sections;
            $this->view->comparison = $comparison;
            $this->view->point_plan_helper = $this->getServiceLocator()->get('ViewHelperManager')->get('pointplan');

            $this->view->back_link = $this->get_client()->get_link('result', array('c24api_calculationparameter_id' => $this->calculationparameter->get_id()));
            $this->view->compare_link = $this->get_client()->get_link('compare', array('c24api_calculationparameter_id' => $this->calculationparameter->get_id()));

            $this->view->calculationparameter = $this->calculationparameter;

            $this->view->generaltracking_pixel  = helper\generaltracking_pv::run($this, 79, 'Compare', 8, strtoupper($this->get_product_api_name()));
            $this->view->generaltracking_pixel2 = helper\generaltracking_pv::run($this, 80, 'Compare', 467, strtoupper($this->get_product_api_name()));


            $this->getServiceLocator()
                ->get('ViewHelperManager')
                ->get('topbar')
                ->setTemplatePath('application/helper/topbar.phtml')
                ->setData(['step' => 2]);


            return new controllerstatus(
                controllerstatus::SUCCESS,
                [
                    'result' => $this->view->render($this->get_product_api_name() . '/compare.phtml'),
                    'head'   => '',
                    'filter' => '',
                    'footer' => ''
                ]
            );

        }

        /**
         * Prepares calculationparameter_id parameter
         * 
         * @return string create_new_calculationparameter_id
         */
        protected function create_new_calculationparameter_id() {

            if (isset($this->parameters['create_new_calculationparameter_id'])) {
                $create_new_calculationparameter_id = $this->parameters['create_new_calculationparameter_id'];
            } else {
                $create_new_calculationparameter_id = 'no';
            }

            return $create_new_calculationparameter_id;
            
        }

    }