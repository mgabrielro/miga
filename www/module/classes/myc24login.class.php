<?php

    namespace classes;

    /**
     * Config class to read and parse init file module/Application/config/config_local.ini
     *
     * @author Tobias Albrecht <tobias.albrecht@check24.de>
     * @copyright rapidsoft GmbH
     * @version 1.0
     */
    class myc24login extends \c24login\apiclient\Client {

        const PARAMETER_ERROR = 350;
        const WRONG_EMAIL    = 501;
        const WRONG_PASSWORD = 503;
        const ACCOUNT_SUSPENDED = 561;
        const ACCOUNT_NOT_ACTIVE = 562;
        const LOGIN_WARNING = 999;
        const LOGIN_NOT_POSSIBLE = 0;
        const SESSION_TIMEOUT_CODE = 551;

        protected $messages = [
            self::WRONG_EMAIL => 'E-Mail-Adresse oder Passwort ist nicht korrekt',
            self::WRONG_PASSWORD => 'E-Mail-Adresse oder Passwort ist nicht korrekt',
            self::ACCOUNT_NOT_ACTIVE => 'Das Konto wurde nocht nicht aktiviert',
            self::ACCOUNT_SUSPENDED => 'Das Konto wurde gesperrt',
            self::LOGIN_WARNING => 'Achtung: Sie haben 3 mal hintereinander ein falsches Passwort eingegeben. Nach der nächsten fehlerhaften eingabe wird Ihr Zugang 1 Stunde gesperrt',
            self::LOGIN_NOT_POSSIBLE => 'Eine Anmeldung am System ist zurzeit leider nicht möglich',
            self::PARAMETER_ERROR => 'Leider ist ein Fehler aufgetreteten. Versuchen Sie es später noch einmal.'
        ];

        /** Testing URL for login */
        const TESTING_LOGIN_SERVER = 'https://login-test.de';

        /**
         * Current instance
         *
         * @var \classes\myc24login
         */
        private static $instance = NULL;

        /**
         * User data coming through last call
         *
         * @var array|NULL
         */
        private $user_data = NULL;

        /**
         * Constructor
         *
         * @return void
         */
        public function __construct() {

            $api_base_url = self::get_server_url('test');

            if (\classes\config::get('environment') !== 'development') {
                $api_base_url = self::get_server_url();
            }

            parent::__construct(
                config::get('c24login_service_id'),
                md5(config::get('c24login_service_secret')),
                $api_base_url
            );

        }

        /**
         * Get instance
         *
         * @return \classes\myc24login
         */
        public static function get_instance() {

            if (self::$instance === NULL) {
                self::$instance = new myc24login();
            }

            return self::$instance;

        }

        /**
         * Get email address
         *
         * @param string $session_id Session id
         * @return string
         */
        public function get_email_address($session_id) {

            \shared\classes\common\utils::check_string($session_id, 'session_id');

            if ($session_id == 'deleted') {
                return NULL;
            } else {

                try {

                    $data = $this->user_validate($session_id, true);
                    return $data['email'];

                } catch (\c24login\apiclient\client\exception\Base $e) {

                    if ($e->get_code() == 551 /* Session expired */) {
                        return $this->get_expired_session_user_email();
                    } else {
                        return NULL;
                    }

                }

            }

        }

        /**
         * Get zipcode
         *
         * @param string $session_id Session id
         * @return string
         */
        public function get_zipcode($session_id) {

            \shared\classes\common\utils::check_string($session_id, 'session_id');

            if ($session_id == 'deleted') {
                return NULL;
            } else {

                try {

                    $data = $this->user_validate($session_id, true);
                    return $data['zipcode'];

                } catch (\c24login\apiclient\client\exception\Base $e) {
                    return NULL;
                }

            }

        }

        /**
         * Get zipcode address
         *
         * @param string $session_id Session id
         * @return string
         */
        public function get_user_zipcode($session_id) {

            \shared\classes\common\utils::check_string($session_id, 'session_id');

            if ($session_id == 'deleted') {
                return NULL;
            } else {

                try {

                    $data = $this->user_validate($session_id, true);
                    return $data['zipcode'];

                } catch (\c24login\apiclient\client\exception\Base $e) {
                    return NULL;
                }

            }

        }

        /**
         * Validates user session on the login server.
         *
         * Set $this->user_data to use for checking
         *
         * @param string $c24session            The c24session ID from the corresponding user
         * @param boolean $load                 Optional: Flag to load the user data
         * @param string $decryption_key        Optional: Key for the creditcard decryption
         * @param boolean $count_cs_codes       Optional: Flag to return the users cs code count
         * @param string $cs_type               Optional: Type of the counted cs codes, default is "voucher"
         * @param boolean $campaigns            Optional: Flag to load user campaigns
         * @param boolean $logintime            Optional: Flag to get users login time (default "true")
         * @param boolean $updatetime           Optional: Flag to get users last update time (default "true")
         * @param boolean $notificationcount    Optional: Flag to get users notification count (default "false")
         * @param   boolean     $wishlistcount      Optional: Flag to get users total wishlist item count (default "false")
         *
         * @return array
         */
        public function user_validate($c24session, $load = false, $decryption_key = NULL, $count_cs_codes = false, $cs_type = 'voucher', $campaigns = false, $logintime = true, $updatetime = true, $notificationcount = false, $wishlistcount = false) {

            if (!$this->user_data) {

                $this->user_data = parent::user_validate(
                    $c24session, $load, $decryption_key, $count_cs_codes, $cs_type, $campaigns, $logintime, $updatetime, $notificationcount, $wishlistcount
                );

            }

            return $this->user_data;

        }

        /**
         * Is super account
         *
         * @return boolean|NULL
         */
        public function is_super_account() {

            // No data loaded

            if ($this->user_data === NULL) {
                return NULL;
            }

            // Check if point member

            return isset($this->user_data['points']) && $this->user_data['points'] == 'yes';

        }

        /**
         * User data loaded by session check.
         *
         * NULL if nothing loaded yet or wrong session.
         * Array with user data from SSO if logged in
         *
         * @return array|NULL
         */
        public function get_user_data() {
            return $this->user_data;
        }

        /**
         * Returns the formated message for an error code
         *
         * @param integer $errorcode Error Code
         * @return string
         */
        public function format_error($errorcode) {
            return $this->messages[$errorcode];
        }

        /**
         * Check if the session is expired
         *
         * @return boolean
         */
        public function is_session_expired () {

            if (!is_null($this->get_response_data())) {

                $data = $this->get_response_data();

                if ($this->get_response_status() === self::SESSION_TIMEOUT_CODE) {

                    if (isset($data['api_data']['user_logged_out']) && $data['api_data']['user_logged_out'] == 'no') {
                        return true;
                    }

                }

            }

            return false;

        }

        /**
         * Return the expired Session user_data
         *
         * @return array
         */
        public function get_expired_session_user_data() {

            $user_data = array();

            if ($this->is_session_expired()) {

                $user_data = $this->get_response_data();

                if (!empty($user_data['api_data'])) {
                    return array_unfix('user_', $user_data['api_data']);
                }

            }

            return $user_data;

        }

        /**
         * Returns the login server url.
         * Switched randomly between the first and second server in the case of production
         *
         * https://jira.check24.de/browse/PVPKV-3524
         * Switching between the live Server.
         *
         * @param string $environment The diffrent environment (prod|test|int)
         * @return string
         */
        public static function get_server_url($environment = 'prod') {

            if($environment == 'int' || $environment == 'test') {
                return parent::get_server_url($environment);
            }

            return static::$first_login_server;

        }

    }
