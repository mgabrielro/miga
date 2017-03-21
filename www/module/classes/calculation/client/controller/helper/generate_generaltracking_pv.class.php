<?php

    namespace classes\calculation\client\controller\helper;
    use \shared\classes\calculation\client\view\helper\base;


        /**
         * Generate Tracking view helper plugin class for tracking visits.
         *
         * @author Igor Duspara <igor.duspara@check24.de>
         */
    class generate_generaltracking_pv extends base {

        private $protocol = 'http';
        private $product_id = 0;
        private $partner_id = 0;
        private $tracking_id = '';
        private $area_id = '';
        private $session_id = '';
        private $action_id = 0;
        private $action_foreign_id = 0;
        private $referer_url = '';
        private $product_name = '';
        private $cpref = '';

        /**
         * Constructor
         *
         * @param \shared\classes\calculation\client\view $view View
         * @param string $protocol Protocol
         * @param integer $product_id Product id
         * @param integer $partner_id Partner id
         * @param string $tracking_id Tracking id
         * @param string $area_id Area id
         * @param string $session_id Session id
         * @param integer $action_id Action id
         * @param integer $action_foreign_id Action foreign id
         * @param string $referer_url Referer url
         * @param string $deviceoutput Deviceoutput
         * @param string $product_name Product Name
         * @return void
         */
        public function __construct(\shared\classes\calculation\client\view $view, $protocol, $product_id, $partner_id, $tracking_id, $area_id, $session_id = '', $action_id = 0, $action_foreign_id = 0, $referer_url = '', $deviceoutput = '', $product_name = '') {

            \shared\classes\common\utils::check_object($view, 'view');
            \shared\classes\common\utils::check_string($protocol, 'protocol', false, array('http', 'https'));
            \shared\classes\common\utils::check_int($product_id, 'product_id');
            \shared\classes\common\utils::check_int($partner_id, 'partner_id');
            \shared\classes\common\utils::check_string($tracking_id, 'tracking_id', true);
            \shared\classes\common\utils::check_string($area_id, 'area_id');
            \shared\classes\common\utils::check_string($session_id, 'session_id', true);
            \shared\classes\common\utils::check_int($action_id, 'action_id', true);
            \shared\classes\common\utils::check_int($action_foreign_id, 'action_foreign_id', true);
            \shared\classes\common\utils::check_string($referer_url, 'referer_url', true);
            \shared\classes\common\utils::check_string($deviceoutput, 'deviceoutput', true);

            $this->protocol = $protocol;
            $this->product_id = $product_id;
            $this->partner_id = $partner_id;
            $this->tracking_id = $tracking_id;
            $this->area_id = $area_id;
            $this->session_id = $session_id;
            $this->action_id = $action_id;
            $this->action_foreign_id = $action_foreign_id;
            $this->referer_url = $referer_url;
            $this->deviceoutput = $deviceoutput;
            $this->product_name = $product_name;
            $this->cpref = $this->get_cpref();

            parent::__construct($view);

        }

        /**
         * Returns the rendered output.
         *
         * @return string
         */
        protected function create_output() {

            $pixel = '<img src="' . urlencode($this->protocol) . '://www.generaltracking.de/gif';
            $pixel .= '/site_id/' . urlencode($this->product_id);
            $pixel .= '/pid/' . urlencode($this->tracking_id);

            if ($this->cpref != '') {
                $pixel .= '/tid/' . urlencode($this->cpref);
            }

            $pixel .= '/area_id/' . urlencode($this->area_id);

            $pixel .= '/product/' . urlencode($this->product_name);

            $pixel .= '/sid/' . urlencode($this->session_id);

            if ($this->action_id > 0) {
                $pixel .= '/action_id/' . urlencode($this->action_id);
            }

            if ($this->deviceoutput != '') {
                $pixel .= '/deviceoutput/' . urlencode($this->deviceoutput);
            }

            // $pixel .= '/tracking_id/' . urlencode($this->tracking_id);

            //$pixel .= '/tid/' . urlencode($this->tracking_id);



            if ($this->action_foreign_id > 0) {
                $pixel .= '/action_foreign_id/' . urlencode($this->action_foreign_id);
            }

            if ($this->referer_url != '') {
                $pixel .= '/ref/' . urlencode($this->referer_url);
            }



            $pixel .= '/info.gif';
            $pixel .= '" style="border: 0 none;" width="1" height="1" alt="" id="c24-tracking-gt-system"/>';

            return $pixel;

        }

        /**
         * Return cpref from Session
         *
         * @return string
         */
        private function get_cpref() {

            if (isset($_SESSION['check24']['cpref'])) {
                return $_SESSION['check24']['cpref'];
            }

        }

    }


