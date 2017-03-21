<?php

    namespace shared\classes\calculation\client\view\helper {

        /**
         * Generate Tracking view helper plugin class for tracking visits.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        class generate_generaltracking extends base {

            private $protocol = 'http';
            private $product_id = 0;
            private $partner_id = 0;
            private $tracking_id = '';
            private $area_id = '';
            private $session_id = '';
            private $action_id = 0;
            private $action_foreign_id = 0;
            private $referer_url = '';
            private $deviceoutput = '';

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
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view, $protocol, $product_id, $partner_id, $tracking_id, $area_id, $session_id = '', $action_id = 0, $action_foreign_id = 0, $referer_url = '', $deviceoutput = '') {

                \shared\classes\calculation\client\common\utils::check_object($view, 'view');
                \shared\classes\calculation\client\common\utils::check_string($protocol, 'protocol', false, array('http', 'https'));
                \shared\classes\calculation\client\common\utils::check_int($product_id, 'product_id');
                \shared\classes\calculation\client\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\calculation\client\common\utils::check_string($tracking_id, 'tracking_id', true);
                \shared\classes\calculation\client\common\utils::check_string($area_id, 'area_id');
                \shared\classes\calculation\client\common\utils::check_string($session_id, 'session_id', true);
                \shared\classes\calculation\client\common\utils::check_int($action_id, 'action_id', true);
                \shared\classes\calculation\client\common\utils::check_int($action_foreign_id, 'action_foreign_id', true);
                \shared\classes\calculation\client\common\utils::check_string($referer_url, 'referer_url', true);
                \shared\classes\calculation\client\common\utils::check_string($deviceoutput, 'deviceoutput', true);

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

                parent::__construct($view);

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected function create_output() {

                $pixel = '<img src="' . urlencode($this->protocol) . '://www.generaltracking.de/gif/site_id/32/pid/' . $this->partner_id;
                $pixel .= '/tid/' . urlencode($this->tracking_id);
                $pixel .= '/area_id/' . urlencode($this->area_id);

                switch ($this->product_id) {

                    case 1 :

                        $pixel .= '/product/strom';
                        break;

                    case 2 :

                        $pixel .= '/product/gas';
                        break;

                    case 3 :

                        $pixel .= '/product/dsl';
                        break;

                    case 4 :

                        $pixel .= '/product/mobile';
                        break;

                    case 5 :

                        $pixel .= '/product/landline';
                        break;

                    case 6 :

                        $pixel .= '/product/mobilesinternet';
                        break;

                }

                $pixel .= '/sid/' . urlencode($this->session_id);

                if ($this->action_id > 0) {
                    $pixel .= '/action_id/' . urlencode($this->action_id);
                }

                if ($this->action_foreign_id > 0) {
                    $pixel .= '/action_foreign_id/' . urlencode($this->action_foreign_id);
                }

                if ($this->referer_url != '') {
                    $pixel .= '/ref/' . urlencode($this->referer_url);
                }

                if ($this->deviceoutput != '') {
                    $pixel .= '/deviceoutput/' . urlencode($this->deviceoutput);
                }

                $pixel .= '/info.gif';
                $pixel .= '" style="border: 0 none;" width="1" height="1" alt=""/>';

                return $pixel;

            }

        }

    }