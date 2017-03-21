<?php

    namespace classes\api;

    /**
     * Get tariffs from api
     *
     * @author Robert Curth <robert.curth@check24.de>
     * @author Lars Kneschke <lars.kneschke@check24.de>
     */
    class participating_tariff extends abstract_cached_api {

        /**
         * @var null|string
         */
        protected $endpoint = 'participating_tariff';

        /**
         * @var mixed|null
         */
        protected $fallback = [];

        /**
         * Fetch a list of all active tariffs
         *
         * @return array of tariffs
         */
        public function get_all() {
            return $this->get_api_result();
        }

    }
