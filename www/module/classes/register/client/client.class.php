<?php

    namespace classes\register\client;

    /**
     * Mobile intern register client
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     */
    class client extends \shared\classes\register\client\client {

        /**
         * Set c24login session cookie.
         *
         * Extend parent class because parent uses .check24.de only. Not recommended for dev
         *
         * @param string $session Session
         * @return void
         */
        public function set_c24login_session_cookie($session) {

            if (\classes\config::get('environment') == 'development') {
                setcookie('c24session', $session, time() + 60 * 60 * 24 * 450, '/', \classes\config::get('cookie_domain'));
            } else {
                parent::set_c24login_session_cookie($session);
            }

        }

    }
