<?php

    namespace classes\special_action;
    use C24\Holding\Core\Exception;

    /**
     * Class special_action
     * @author Jaha Deliu <jaha.deliu@check24.de>
     */
    class special_action {

        /**
         * Is the special action active?
         *
         * @var string
         */
        protected $active = 'no';

        /**
         * Special action free monthgs
         *
         * @var integer
         */
        protected $max_free_months = 0;

        /**
         * Max. voucher value
         *
         * @var int
         */
        protected $max_voucher_value = 0;

        /**
         * How long is the special action valid?
         */
        protected $valid_to = NULL;


        private static $instance = NULL;

        private $smarty = NULL;

        /**
         * Get instance
         *
         * @return special_action|null
         */
        public static function get_instance() {

            if (self::$instance === NULL) {
                self::$instance = new self();
            }

            return self::$instance;

        }

        /**
         * Constructor
         *
         * @return void
         */
        public function __construct() {
            $this->smarty = get_smarty();
        }

        /**
         * Generate the HTML output for the action banner
         *
         * @param array $data Special Action Tariff Data
         * @param integer $ribbon_type Ribbon type to output
         *
         * @return mixed bool|string
         */
        public function generate_html($data, $ribbon_type = 1) {

            $this->data_array_to_params($data);

            $output_html = false;

            if ($this->active == 'yes' &&
                date('Y-m-d H:i:s', strtotime($this->valid_to)) >= date('Y-m-d H:i:s')) {

                $valid_to_date = date('d.m.', strtotime($this->valid_to));
                $valid_to_date_full = date('d.m.Y', strtotime($this->valid_to));;
                $free_months = $this->max_free_months;
                $max_voucher_value = $this->max_voucher_value;
                $monate_text = ($free_months) > 1 ? 'Monate' : 'Monat';
                $action_text_how_many_free = $free_months . ' ' . $monate_text . ' gratis';
                $action_text_to_date = '(nur bis ' . $valid_to_date . ')';


                $this->smarty->assign('valid_to_date', $valid_to_date);
                $this->smarty->assign('valid_to_date_full', $valid_to_date_full);
                $this->smarty->assign('free_months', $free_months);
                $this->smarty->assign('max_voucher_value', $max_voucher_value);
                $this->smarty->assign('monate_text', $monate_text);
                $this->smarty->assign('action_text_how_many_free', $action_text_how_many_free);
                $this->smarty->assign('action_text_to_date', $action_text_to_date);
                $this->smarty->assign('ribbon_type', $ribbon_type);

                $output_html = $this->smarty->fetch('form/includes/special_action.tpl');

            }

            return $output_html;

        }

        /**
         * Sets the parameters by the given data array
         *
         * @param array $data Special Action data
         *
         * @return void
         */
        protected function data_array_to_params($data) {

            check_array($data, 'data');

            // expected data array names. this keys has to be defined as properties of the current class
            $params = ['active', 'max_free_months', 'max_voucher_value', 'valid_to'];

            for ($i = 0; $i < sizeof($params); $i++) {

                if (array_key_exists($params[$i], $data) && property_exists(get_class($this), $params[$i])) {
                    $this->{$params[$i]} = $data[$params[$i]];
                }

            }

        }

        /**
         * Cheks if there are active special actions
         *
         * @return boolean
         */
        public function has_active_actions() {
            $rest_client = $this->get_client()->rest_client();
            $response = $rest_client->send_request(\shared\classes\common\rs_rest_client\rs_rest_client::METHOD_GET, 'tariff_action');
            return (bool) $response['data']['special_action'];
        }

    }