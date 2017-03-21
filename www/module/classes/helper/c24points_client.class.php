<?php

    namespace classes\helper;

    use \shared\classes\cscode\client\helper\dataobject\csplan;
    use Psr\Log\LoggerAwareInterface;
    use Psr\Log\LoggerAwareTrait;

    /**
     * Pointplan client class
     *
     * @author Jaha Deliu
     * @author Lars Kneschke <lars.kneschke@check24.de>
     */
    class c24points_client implements  LoggerAwareInterface {

        use LoggerAwareTrait;

        /**
         * @var string
         */
        private $host = '';

        /**
         * @var string
         */
        private $username = '';

        /**
         * @var string
         */
        private $password = '';

        /**
         * Constructor
         *
         * @param string $host                                    Host.
         * @param string $username                                Username.
         * @param string $password                                Password.
         * @return void
         */
        public function __construct($host, $username, $password) {

            \shared\classes\common\utils::check_string($host, 'host');
            \shared\classes\common\utils::check_string($username, 'username');
            \shared\classes\common\utils::check_string($password, 'password');

            $this->host = $host;
            $this->username = $username;
            $this->password = $password;

        }

        /**
         * Do api request and map data to response object
         *
         * @param string $module Api module
         * @param array $parameters Parameters
         * @param string $method Method
         * @return response
         */
        private function request($module, $parameters, $method = \shared\classes\common\rs_rest_client\rs_rest_client::METHOD_GET) {

            \shared\classes\common\utils::check_string($module, 'module');
            \shared\classes\common\utils::check_array($parameters, 'parameters', true);

            // Do request
            $client = new \shared\classes\common\rs_rest_client\rs_rest_client(
                $this->host, $this->username, $this->password, false
            );

            $response = $client->send_request($method, $module, NULL, $parameters);

            return $response;

        }


        /**
         * Get c24points
         *
         * @param string $email User email
         * @param string $password User password - already hashed
         * @return response
         */
        public function get_points($email, $password) {

            $point_plan = $this->get_point_plan($email, $password);

            if ($point_plan instanceof csplan) {
                return $point_plan->get_value();
            } else {
                return 0;
            }

        }

        /**
         * Get c24point plan
         *
         * @param string $email User email
         * @param string $password User password - alredy hashed
         * @return csplan|boolean
         */
        public function get_point_plan($email, $password) {

            \shared\classes\common\utils::check_string((string)$email, 'email');
            \shared\classes\common\utils::check_string($password, 'password');

            $parameters = [
                'c24api_email' => $email,
                'c24api_password' => $password
            ];

            $plan = false;

            try {

                $response = $this->request('c24pointplan/get_c24point_plan', $parameters, \shared\classes\common\rs_rest_client\rs_rest_client::METHOD_POST);

                if ($response['status_code'] == 200 && isset($response['data']['plan']) && is_array($response['data']['plan'])) {
                    $plan = new csplan($response['data']['plan']);
                }

            } catch (\Exception $ex) {

                // exception\base log them self

                if (! $ex instanceof \shared\classes\common\exception\base) {
                    $this->logger->error($ex->getMessage(), ['exception' => $ex]);
                }

            }

            return $plan;

        }

    }
