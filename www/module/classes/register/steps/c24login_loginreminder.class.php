<?php

    namespace classes\register\steps;

    /**
     * C24login register step
     *
     * @author Tobias Albrecht <tobias.albrecht@check24.de>
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class c24login_loginreminder extends base {

        /**
         * Get view
         *
         * @return string
         */
        public function get_view() {
            return 'c24login_loginreminder.phtml';
        }

        /**
         * Redirect to c24login_login but extend with reminder success message
         *
         * @return \Zend\Http\Response
         */
        public function handle_success() {

            return $this->get_registermanager()->get_controller()->redirect_to_step(
                $this->get_registermanager()->get_registercontainer_id(),
                $this->get_registermanager()->get_product_id(),
                'c24login_login',
                ['reminder_success' => 1]
            );

        }

    }