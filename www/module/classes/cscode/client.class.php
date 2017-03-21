<?php

    namespace classes\cscode;

    /**
     * CSCOde client wrapper. Primarly to set the config
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     */
    class client extends \shared\classes\cscode\client {

        /**
         * Set config and overwrite constructor
         *
         * @return void
         */
        public function __construct() {

            $client_config = [
                'host' => \classes\config::get('register_api_host'),
                'username' => \classes\config::get('register_api_user'),
                'password' => \classes\config::get('register_api_pass'),
                'cookie_domain' => '.check24.de',
            ];

            parent::__construct($client_config);

        }

    }
