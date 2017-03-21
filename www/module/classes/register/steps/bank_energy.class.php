<?php

    namespace classes\register\steps {
        use pollmanager\helper\exception;

        /**
         * Bank energy step
         *
         * @author Andreas Buchenrieder <andreas.buchenrieder@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class bank_energy extends base {

            /**
             * Get view
             *
             * @return string
             */
            public function get_view() {
                return 'bank_energy.phtml';
            }

            /**
             * Handle request
             *
             * @return boolean
             */
            public function handle_request() {

                parent::handle_request();

                $information = $this->get_registermanager()->get_step_information();

                foreach ($information AS $key => $info) {

                    $this->get_registermanager()->assign_data(
                        $key,
                        $info
                    );

                }

                $this->get_registermanager()->assign_data(
                    'link_ajax_json_bankname',
                    $this->get_registermanager()->get_controller()->get_ajax_json_url('bankname')
                );

                $this->get_registermanager()->assign_data(
                    'link_ajax_json_city',
                    $this->get_registermanager()->get_controller()->get_ajax_json_url('city')
                );

                $this->get_registermanager()->assign_data(
                    'provider_name',
                    $this->get_registermanager()->get_registertariff()->get_provider_name()
                );

                $this->get_registermanager()->assign_data(
                    'provider_address',
                    $this->get_registermanager()->get_registertariff()->get_provider_address_street() . ', ' . $this->get_registermanager()->get_registertariff()->get_provider_address_zipcode() . ' ' . $this->get_registermanager()->get_registertariff()->get_provider_address_city()
                );

                $this->get_registermanager()->assign_data(
                    'provider_creditor',
                    $this->get_registermanager()->get_step_information('donor_identification')
                );

                $this->get_registermanager()->assign_data(
                    'product_id',
                    $this->get_registermanager()->get_registertariff()->get_tariff_product_id()
                );

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

                $radio_options = array(
                    'paymenttype' => array(
                        'directdebit' => 'Lastschrift',
                        'transfer'    => 'Überweisung'
                    ),
                    'banktype' => array(
                        'classic' => 'Kto.-Nr.&nbsp;',
                        'sepa' => '&nbsp;IBAN'
                    ),
                    'accountowner_type' => array(
                        'self' => 'Antragssteller',
                        'other' => 'Abweichend'
                    )
                );

                if (isset($radio_options[$name])) {
                    $definition['option'] = $radio_options[$name];
                }

                $label_mapping = array(
                    'paymenttype' => '',
                    'banktype' => 'Angabe Bankverbindung',
                    'alternative_accountowner' => 'alternative_accountowner',
                    'accountowner_type' => 'Kontoinhaber gleich Antragssteller',
                    'accountowner_gender' => 'Anrede *',
                    'accountowner_city' => 'Ort *',
                    'accountowner_street' => 'Straße *',
                );

                if (isset($label_mapping[$name])) {

                    if ($definition['type'] == 'select' && isset($definition['option'][''])) {
                        $definition['option'][''] = $label_mapping[$name];
                    } else if ($definition['type'] == 'radio') {
                        $definition['label'] = $label_mapping[$name];
                    }

                }

                return parent::create_field($name, $definition);

            }

            /**
             * Handle load
             *
             * @return void
             */
            public function handle_load() {

                $default_value_mapping = array(
                    'accountowner_type' => 'self'
                );

                $options = $this->get_registermanager()->get_form()->get('paymenttype')->getValueOptions();

                if (count($options) == 1) {
                    $default_value_mapping['paymenttype'] = $options[0]['value'];
                } else {
                    $default_value_mapping['paymenttype'] = 'directdebit';
                }

                $options = $this->get_registermanager()->get_form()->get('banktype')->getValueOptions();

                if (count($options) == 1) {
                    $default_value_mapping['banktype'] = $options[0]['value'];
                } else {
                    $default_value_mapping['banktype'] = 'classic';
                }

                foreach ($default_value_mapping AS $field => $value) {

                    if ($this->get_registermanager()->get_form()->has($field) && $this->get_registermanager()->get_form()->get($field)->getValue() === NULL) {
                        $this->get_registermanager()->get_form()->get($field)->setValue($value);
                    }

                }

            }

        }

    }
