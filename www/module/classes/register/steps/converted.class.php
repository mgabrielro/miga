<?php

    namespace classes\register\steps;

    /**
     * Converted pv step
     *
     * @author Marco Walther <marco.walther@check24.de>
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class converted extends base {

        /**
         * Get view
         *
         * @return string
         */
        public function get_view() {
            return 'converted.phtml';
        }

        /**
         * Handle request
         *
         * @return boolean
         */
        public function handle_request() {

            parent::handle_request();

            $response = $this->get_registermanager()->get_registerclient()->post_step_data(
                $this->get_registermanager()->get_product_name($this->get_registermanager()->get_product_id()),
                $this->get_registermanager()->get_registercontainer_id(),
                ['c24api_session_id' => session_id()],
                'converted'
            );

            $data = $response->get_data();

            // Check for existing error, redirect to 404

            if (isset($data['error'])) {

                $this->get_registermanager()->get_controller()->notFoundAction();
                return true;

            }


            // Set the defaults, they will be overwritten with if lead is created.
            $availability = get_def('register_phone_availability/0');
            $phone_number = get_def('register_phone_number/0');
            $provider_name = $data['registertariff']['provider']['name'];

            if (isset($data['lead'])) {

                $product_id = $data['lead']['product_id'];

                // TODO Subject of refactoring thema : PVPKV-1450
                if($product_id == 21) { // PKV
                    $offer_id = 'PKV&nbsp;' . $data['lead']['id'];
                } else {
                    $offer_id = strtoupper(get_def('product/' . $product_id)) . '&nbsp;' . $data['lead']['id'];
                }

                $availability = get_def('register_phone_availability/' . $product_id);
                $phone_number = get_def('register_phone_number/' . $product_id);
                $this->get_registermanager()->assign_data('offer_id', $offer_id);
                $this->get_registermanager()->assign_data('lead', $data['lead']);
            }

            $this->get_registermanager()->assign_data('subscriptiontype', $data['lead']['subscriptiontype']);
            $this->get_registermanager()->assign_data('availability', $availability);
            $this->get_registermanager()->assign_data('phone_number', $phone_number);
            $this->get_registermanager()->assign_data('provider_name', $provider_name);
            $this->get_registermanager()->assign_data('response', $response);
            $this->get_registermanager()->assign_data('cct_loader', $this->getServiceLocator()->get('ZendConfig')->check24->cct->baseurl );

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

            foreach ($this->register_data['form_definition'] AS $field => $definition) {

                if ($definition['type'] === 'select' && count($definition['allowed_option']) == 1) {
                    $this->get_registermanager()->get_form()->get($field)->setValue(current($definition['allowed_option']));
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
