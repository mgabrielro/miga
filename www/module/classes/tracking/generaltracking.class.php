<?php


    namespace classes\tracking;

    /**
     * Class generaltracking which represents one general tracking pixel and is able to render the html for it.
     *
     * @author Stephan Eicher <stephan.eicher@check24.de>
     */
    class generaltracking extends base {

        /**
         * @var string Tracking ID (User jump in)
         */
        private $tid = NULL;

        /**
         * @var string Partner ID
         */
        private $pid = NULL;

        /**
         * @var integer Site ID
         */
        private $site_id = NULL;

        /**
         * @var string Area ID which describes the side which was requested by the user
         */
        private $area_id = NULL;

        /**
         * @var string Product
         */
        private $product = NULL;

        /**
         * @var integer Action ID
         */
        private $action_id = NULL;

        /**
         * @var string Session ID
         */
        private $sid = NULL;

        /**
         * @var string Output device of the user (tablet, desktop, ...)
         */
        private $deviceoutput = NULL;

        /**
         * @var string Referrer
         */
        private $referrer = NULL;

        /**
         * @var integer Foreign action ID
         */
        private $action_foreign_id = NULL;

        /**
         * Constructor
         *
         * @param NULL $site_id Site id
         * @param NULL $pid Partner id
         * @param NULL $tid Tracking id
         * @param NULL $area_id Area id
         * @param NULL $product Product
         * @param NULL $action_id Action id
         * @param NULL $sid Session id
         * @param NULL $deviceoutput Outputdevice
         * @param NULL $foreign_action_id Action id
         * @param NULL $referrer Referrer
         * @return void
         */
        public function __construct($site_id = NULL, $pid = NULL, $tid = NULL, $area_id = NULL, $product = NULL, $action_id = NULL, $sid = NULL, $deviceoutput = NULL, $foreign_action_id = NULL, $referrer = NULL) {

            $this->set_site_id($site_id);
            $this->set_pid($pid);
            $this->set_tid($tid);
            $this->set_area_id($area_id);
            $this->set_product($product);
            $this->set_action_id($action_id);
            $this->set_sid($sid);
            $this->set_deviceoutput($deviceoutput);
            $this->set_action_foreign_id($foreign_action_id);
            $this->set_referrer($referrer);

        }

        /**
         * Generates the general tracking pixel (html)
         *
         * @return string
         */
        public function render() {

            $output = '';

            if (!empty($this->get_site_id())) {
                $output .= 'site_id/' . urlencode($this->get_site_id()) . '/';
            }

            if (!empty($this->get_pid())) {
                $output .= 'pid/' . urlencode($this->get_pid()) . '/';
            }

            if (!empty($this->get_tid())) {
                $output .= 'tid/' . urlencode($this->get_tid()) . '/';
            }

            if (!empty($this->get_area_id())) {
                $output .= 'area_id/' . urlencode(strtolower($this->get_area_id())) . '/';
            }

            if (!empty($this->get_action_id())) {
                $output .= 'action_id/' . urlencode($this->get_action_id()) . '/';
            }

            if (!empty($this->get_action_foreign_id())) {
                $output .= 'action_foreign_id/' . urlencode($this->get_action_foreign_id()) . '/';
            }

            if (!empty($this->get_product())) {
                $output .= 'product/' . urlencode(strtolower($this->get_product())) . '/';
            }

            if (!empty($this->get_sid())) {
                $output .= 'sid/' . urlencode($this->get_sid()) . '/';
            }

            if (!empty($this->get_deviceoutput())) {
                $output .= 'deviceoutput/' . urlencode($this->get_deviceoutput()) . '/';
            }

            if (!empty($this->get_referrer())) {
                $output .= 'ref/' . urlencode($this->get_referrer()) . '/';
            }

            if (!empty($output)) {

                $script = '<script type="text/javascript">';
                $script .= '(new Image()).src = "https://www.generaltracking.de/gif/' . $output . 'info.gif";';
                $script .= '</script>';

                $output = $script;

            }

            return $output;

        }

        /**
         * Returns output device
         *
         * @return string
         */
        public function get_deviceoutput() {
            return $this->deviceoutput;
        }

        /**
         * Set output device
         *
         * @param string $deviceoutput Deviceoutput normally "desktop" or "tablet"
         * @return void
         */
        public function set_deviceoutput($deviceoutput) {
            $this->deviceoutput = $deviceoutput;
        }

        /**
         * Return session id
         *
         * @return string
         */
        public function get_sid() {
            return $this->sid;
        }

        /**
         * Set session id
         *
         * @param string $sid Session id
         * @return void
         */
        public function set_sid($sid) {
            $this->sid = $sid;
        }

        /**
         * Returns the action id
         *
         * @return integer
         */
        public function get_action_id() {
            return $this->action_id;
        }

        /**
         * Set action id
         *
         * @param integer $action_id Action id for/from generaltracking system
         * @return void
         */
        public function set_action_id($action_id) {
            $this->action_id = $action_id;
        }

        /**
         * Returns product string (khzv, hbzv, zzv)
         *
         * @return string
         */
        public function get_product() {
            return $this->product;
        }

        /**
         * Set product string
         *
         * @param string $product KHZV, HBZV, ZZV
         * @return void
         */
        public function set_product($product) {
            $this->product = $product;
        }

        /**
         * Returns the area id
         *
         * @return string
         */
        public function get_area_id() {
            return $this->area_id;
        }

        /**
         * Set area id
         *
         * @param string $area_id Area id for/from generaltracking system
         * @return void
         */
        public function set_area_id($area_id) {
            $this->area_id = $area_id;
        }

        /**
         * Get site id
         *
         * @return integer
         */
        public function get_site_id() {
            return $this->site_id;
        }

        /**
         * Set site id
         *
         * @param integer $site_id Site id for/from generaltracking system
         * @return void
         */
        public function set_site_id($site_id) {
            $this->site_id = $site_id;
        }

        /**
         * Get pid
         *
         * @return string
         */
        public function get_pid() {
            return $this->pid;
        }

        /**
         * Set partner id
         *
         * @param string $pid Partner id
         * @return void
         */
        public function set_pid($pid) {
            $this->pid = $pid;
        }

        /**
         * Returns tracking id
         *
         * @return string
         */
        public function get_tid() {
            return $this->tid;
        }

        /**
         * Set tracking id
         *
         * @param string $tid Tracking id
         * @return void
         */
        public function set_tid($tid) {
            $this->tid = $tid;
        }

        /**
         * Returns foreign action id
         *
         * @return integer
         */
        public function get_action_foreign_id() {
            return $this->action_foreign_id;
        }

        /**
         * Set foreign action id
         *
         * @param integer $action_foreign_id Foreign action id (refers to action id)
         * @return void
         */
        public function set_action_foreign_id($action_foreign_id) {
            $this->action_foreign_id = $action_foreign_id;
        }

        /**
         * Returns referrer
         *
         * @return string
         */
        public function get_referrer() {
            return $this->referrer;
        }

        /**
         * Set referrer
         *
         * @param string $referrer Referrer from
         * @return void
         */
        public function set_referrer($referrer) {
            $this->referrer = $referrer;
        }

    }
