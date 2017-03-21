<?php

    namespace classes\register\steps {

        /**
         * C24login type step
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class c24login_type extends base {

            /**
             * Get view
             *
             * @return string
             */
            public function get_view() {
                return 'c24login_type.phtml';
            }

            /**
             * Handle request
             *
             * @return boolean
             */
            public function handle_request() {

                // We handle here register api saves by us self

                switch ($this->get_registermanager()->get_controller()->get_url_parameter_value('type')) {

                    case 'register' :

                        $this->handle_c24login_type('register');
                        break;

                    case 'login' :

                        $this->handle_c24login_type('login');
                        break;

                    case 'none' :

                        $this->handle_c24login_type('none');
                        break;

                    case 'loginreminder' :

                        $this->handle_c24login_type('loginreminder');
                        break;

                }

                return false;

            }

            /**
             * Handle c24login type
             *
             * @param string $type Type
             * @return void
             */
            private function handle_c24login_type($type) {

                \shared\classes\common\utils::check_string($type, 'type', false, array('register', 'login', 'none', 'loginreminder'));

                $response = \classes\register\registermanager::get_registerclient()->post_step_data(
                    \classes\register\registermanager::get_product_name($this->get_registermanager()->get_product_id()),
                    $this->get_registermanager()->get_registercontainer_id(),
                    array('c24login_type' => $type),
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

        }

    }