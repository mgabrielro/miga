<?php
    namespace classes\api;

    use \shared\classes\common\rs_rest_client\rs_rest_client;
    use \shared\classes\common\rs_rest_client\rs_rest_exception;

    /**
     * Simple wrapper for rest client that returns a fallback on failure
     *
     * @author Robert Curth <robert.curth@check24.de>
     */
    class fallback_api_client {

        /**
         * @var null|string
         */
        protected $endpoint;

        /**
         * @var mixed|null
         */
        protected $fallback;

        /**
         * @var null|rs_rest_client
         */
        protected $rest_client;

        /**
         * Consructor
         *
         * @param string $endpoint API endpoint path
         * @param mixed $fallback Fallback, that is returned in case of error
         * @param rs_rest_client $rest_client Rest client
         *
         * @return void
         */
        public function __construct($rest_client = NULL) {
            if (!$rest_client){
                $rest_client = new rs_rest_client(
                    \classes\config::get('register_api_host'),
                    \classes\config::get('register_api_user'),
                    \classes\config::get('register_api_pass')
                );

            }

            $this->rest_client = $rest_client;
        }

        /**
         * Runs the api call
         *
         * @return mixed Result data or fallback
         */
        public function run() {

            try {
                $result = $this->rest_client->send_request('GET', $this->endpoint);
            } catch(rs_rest_exception $err) {
                return $this->fallback;
            }

            if (!$this->status_code_ok($result)) {
                return $this->fallback;
            }

            return (isset($result['data'])) ? $result['data'] : $this->fallback;

        }

        /**
         * Checks if status code is ok
         *
         * @param array $result API result
         *
         * @return boolean
         */
        protected function status_code_ok($result) {
            return isset($result['status_code']) && $result['status_code'] == 200;
        }

        /**
         * Get the endpoint
         *
         * @return null|string
         */
        public function get_endpoint() {
            return $this->endpoint;
        }

        /**
         * Set the endpoint
         *
         * @param null|string $endpoint
         * @return fallback_api_client
         */
        public function set_endpoint($endpoint) {

            $this->endpoint = $endpoint;

            return $this;

        }

        /**
         * Set fallback parameters
         *
         * @return mixed|null
         */
        public function get_fallback() {
            return $this->fallback;
        }

        /**
         * Get fallback parameters
         *
         * @param mixed|null $fallback
         * @return fallback_api_client
         */
        public function set_fallback($fallback) {

            $this->fallback = $fallback;

            return $this;

        }

    }