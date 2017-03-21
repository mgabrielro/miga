<?php

    namespace classes\api;

    use \shared\classes\common\utils;
    use \classes\register;

    /**
     * Get the campaign period info from api
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     */
    class campaign_period {

        /**
         * Get campaign data
         *
         * @param string $campaign_name The name of the campaign
         * @return array|NULL
         */
        public static function get($campaign_name) {

            utils::check_string($campaign_name, 'campaign_name');

            // Send shared request

            $client = new register\client\client(
                \classes\config::get('register_api_host'),
                \classes\config::get('register_api_user'),
                \classes\config::get('register_api_pass')
            );

            $res = $client->campaign_period($campaign_name);

            return $res->get_data();

        }

    }
