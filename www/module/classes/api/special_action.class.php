<?php

    namespace classes\api;

    use DateTime;

    /**
     * Checks for active special actions
     *
     * @author Robert Curth <robert.curth@check24.de>
     * @author Lars Kneschke <lars.kneschke@check24.de>
     */
    class special_action extends abstract_cached_api {

        /**
         * @var null|string
         */
        protected $endpoint = 'tariff_action';

        /**
         * @var mixed|null
         */
        protected $fallback = ['special_action' => false];

        /**
         * Is the special_action active
         *
         * @return boolean
         */
        public function is_active() {

            $res = $this->get_api_result();

            return (boolean) $res['special_action'];

        }

        /**
         * Until when is the special action valid
         *
         * @return DateTime
         */
        public function valid_until() {

            $res = $this->get_api_result();

            $valid_until = new DateTime($res['valid_until']);

            return new DateTime($valid_until->format('y-m-d'));

        }

        /**
         * How many free months do we offer
         *
         * @return integer
         */
        public function free_months() {

            $res = $this->get_api_result();

            return (integer)$res['free_month'];

        }

        /**
         * The maximum value of the voucher
         *
         * @return integer
         */
        public function max_voucher_value() {

            $res = $this->get_api_result();

            return (integer)$res['max_voucher_value'];

        }

    }