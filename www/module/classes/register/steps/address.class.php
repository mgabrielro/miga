<?php

    namespace classes\register\steps;

    /**
     * Address energy step
     *
     * @author Andreas Buchenrieder <andreas.buchenrieder@check24.de>
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class address extends base {

        /**
         * Get view
         *
         * @return string
         */
        public function get_view() {
            return 'address.phtml';
        }

        /**
         * Handle request
         *
         * @return boolean
         */
        public function handle_request() {

            parent::handle_request();
            $rank_session = new \Zend\Session\Container('c24rank', $this->getServiceLocator()->get('Common\Session\Manager'));
            $registermanager = $this->get_registermanager();
            $rank_data = $rank_session->offsetExists($registermanager->get_registertariff()->get_tariff_variation_key());

            $c24login_type = ($registermanager->get_form()->get('c24login_type')->getValue() != '') ?
                $registermanager->get_form()->get('c24login_type')->getValue() :
                'none';

            $registermanager->assign_data('c24_tariff_rank', ($rank_data ? $rank_data : '0'));
            $registermanager->assign_data('show_address_extra', $registermanager->get_step_information('address_extra') == 'yes');
            $registermanager->assign_data('c24login_type', $c24login_type);
            $registermanager->assign_data('tariffs', $this->getServiceLocator()->get('participating_tariff')->get_all());

            return true;

        }

        /**
         * Create a field with given definition
         *
         * @param string $name Field name
         * @param array $definition Field definition
         *
         * @return fields\base
         */
        protected function create_field($name, $definition) {

            static $label_mapping = array(
                'gender'                         => 'Anrede',
                'title'                          => 'Titel',
                'insure_title'                   => 'Titel',
                'insure_gender'                  => 'Anrede',
                'legalform'                      => 'Geschäftsform'
            );

            if ($name == 'birthdate') {
                $definition['type'] = 'date';
            }

            if ($name == 'insure' || $name == 'insureaddressdiffers') {
                $definition['type'] = 'radio_list';
                $definition['allowed_values'] = $definition['allowed_option'];
            }

            if ($name === 'customdata_refresh') {

                $definition['option'] = array(
                    'yes' => 'ja',
                    'no' => 'nein'
                );

            }

            if (isset($label_mapping[$name])) {

                if ($definition['type'] == 'select' && isset($definition['option'][''])) {
                    $definition['option'][''] = $label_mapping[$name];
                } else if ($definition['type'] == 'radio') {
                    $definition['label'] = $label_mapping[$name];
                }

            }

            // Add the label to the dropdown, don't worry it's disabled.

            if ($name == 'title' || $name == 'insure_title') {
                $definition['option'][''] = $label_mapping[$name];
                ksort($definition['option']);
            }

            return fields\address::create(
                $name,
                $this->get_registermanager()->get_form(),
                $this->get_registermanager()->get_inputfilter(),
                $definition
            );

        }

        /**
         * Handle load
         *
         * @return void
         */
        public function handle_load() {

            if ($this->get_registermanager()->get_form()->has('customdata_refresh') && $this->get_registermanager()->get_form()->get('customdata_refresh')->getValue() != 'yes') {
                $this->get_registermanager()->get_form()->get('customdata_refresh')->setValue('no');
            }

            $c24coupon_code = '';
            $forminput_cs_code = '';

            // TODO: FOr the moment PKV doesn't need the feature. To be solved, when PKV implements coupon codes
            /*try {

                if ($this->get_registermanager()->get_controller()->get_cs_code()) {
                    $c24coupon_code = $this->get_registermanager()->get_controller()->get_cs_code()->get_code();
                }

                $forminput_cs_code = $this->get_registermanager()->get_form()->get('coupon_code')->getValue();

            } catch (\Exception $ex) {

                // exception\base log them self
                if (! $ex instanceof \shared\classes\common\exception\base) {
                    $this->logger->error($ex->getMessage(), ['exception' => $ex]);
                }

            }*/

            foreach ($this->register_data['form_definition'] AS $field => $definition) {

                if ($definition['type'] === 'select' && count($definition['allowed_option']) == 1) {
                    $this->get_registermanager()->get_form()->get($field)->setValue(current($definition['allowed_option']));
                }

                if ($field == 'coupon_code' && empty($form_cs_code) && !empty($c24coupon_code)) {
                    $this->get_registermanager()->get_form()->get($field)->setValue($c24coupon_code);
                }

            }

        }

        /**
         * Handle success
         *
         * Save data to register manager
         *
         * @return mixed NULL if go on normally
         */
        public function handle_success() {

            $session_id = $this->get_registermanager()->get_step_information('session_id');

            if ($session_id != '') {
                $this->get_registermanager()->get_registerclient()->set_c24login_session_cookie($session_id);
            }

            return parent::handle_success();

        }

    }
