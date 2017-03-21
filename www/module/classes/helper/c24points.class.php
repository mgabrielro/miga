<?php
    namespace classes\helper;

    use Psr\Log\LoggerAwareInterface;
    use Psr\Log\LoggerAwareTrait;

    /**
     * c24points helper class
     *
     * @author Jaha Deliu
     * @author Lars Kneschke <lars.kneschke@check24.de>
     */
    class c24points implements LoggerAwareInterface{

        use LoggerAwareTrait;

        /**
         * c24login
         *
         * @var \classes\myc24login
         */
        protected $c24login;

        /**
         * c24point plan
         *
         * @var array
         */
        protected $c24point_plan = NULL;

        /**
         * Construct
         *
         * @param \classes\myc24login $c24login Client
         * @return void
         */
        public function __construct(\classes\myc24login $c24login) {
            $this->c24login = $c24login;
        }

        /**
         * Get the c24points from holding pointplan
         *
         * @return integer c24points
         */
        public function get_points() {

            $point_plan = $this->get_point_plan();

            if (is_array($point_plan) && isset($point_plan['value'])) {
                return $point_plan['value'];
            } else {
                return 0;
            }

        }

        /**
         * Get the c24point plan
         *
         * @return array|boolena the point plan
         */
        public function get_point_plan() {

            if ($this->c24point_plan !== NULL) {
                return $this->c24point_plan;
            }

            $userdata = $this->c24login->get_user_data();

            if (!is_array($userdata)) {
                return false;
            }

            $c24points_client = new \classes\helper\c24points_client(
                \classes\config::get('register_api_host'),
                \classes\config::get('register_api_user'),
                \classes\config::get('register_api_pass')
            );

            // inject logger

            $c24points_client->setLogger($this->logger);

            $this->c24point_plan = $c24points_client->get_point_plan($userdata['email'], $userdata['password']);

            return $this->c24point_plan;

        }

    }
