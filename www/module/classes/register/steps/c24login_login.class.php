<?php

    namespace classes\register\steps {

        /**
         * C24login login step
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class c24login_login extends base {

            /**
             * Get view
             *
             * @return string
             */
            public function get_view() {
                return 'c24login_login.phtml';
            }

            /**
             * Handle request
             *
             * @return boolean
             */
            public function handle_request() {

                parent::handle_request();

                $registermanager = $this->get_registermanager();

                $registermanager->assign_data('link_register_step_c24login_reminder',

                    $registermanager->get_controller()->generate_step_url(
                        $registermanager->get_registercontainer_id(),
                        $registermanager->get_product_id(),
                        'c24login_type'
                    ) . '?type=loginreminder'

                );

                $registermanager->assign_data('link_register_step_c24login_register',

                    $registermanager->get_controller()->generate_step_url(
                        $registermanager->get_registercontainer_id(),
                        $registermanager->get_product_id(),
                        'c24login_type'
                    ) . '?type=register'

                );
                
                $registermanager->assign_data('deviceoutput', $this->get_registerclient());

                return true;

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
                $this->get_registermanager()->get_registerclient()->set_c24login_session_cookie($session_id);

                return parent::handle_success();

            }

        }

    }