<?php

    namespace classes\register\steps {

        /**
         * C24login register step
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class c24login_register extends base {

            /**
             * Get view
             *
             * @return string
             */
            public function get_view() {
                return 'c24login_register.phtml';
            }

            /**
             * Handle request
             *
             * @return boolean
             */
            public function handle_request() {

                parent::handle_request();

                $this->get_registermanager()->assign_data('link_register_step_c24login_reminder',

                    $this->get_registermanager()->get_controller()->generate_step_url(
                        $this->get_registermanager()->get_registercontainer_id(),
                        $this->get_registermanager()->get_product_id(),
                        'c24login_type'
                    ) . '?type=loginreminder'

                );
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

                if ($this->get_registermanager()->get_step_information('login_first') == true) {

                    $session_id = $this->get_registermanager()->get_step_information('session_id');
                    $this->get_registermanager()->get_registerclient()->set_c24login_session_cookie($session_id);

                } else {

                    $response = \classes\register\registermanager::get_registerclient()->post_step_data(
                        \classes\register\registermanager::get_product_name($this->get_registermanager()->get_product_id()),
                        $this->get_registermanager()->get_registercontainer_id(),
                        array('c24login_type' => 'register'),
                        'c24login_type'
                    );

                    if ($response->get_status_code() == 200) {

                        $response_data = $response->get_data();

                        // Redirect to next step

                        $next_step = \classes\register\registermanager::get_next_step('c24login_type', $response_data['steps']);

                        if ($next_step != '') {

                            $this->get_registermanager()->get_controller()->redirect_to_step(
                                $this->get_registermanager()->get_registercontainer_id(),
                                $this->get_registermanager()->get_product_id(),
                                $next_step
                            );

                        }

                    } else {
                        throw new \shared\classes\common\exception\logic('C24login type none expected return code');
                    }

                }

                return parent::handle_success();

            }

        }

    }