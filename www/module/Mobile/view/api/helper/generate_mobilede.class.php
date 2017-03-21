<?php

    namespace shared\classes\calculation\client\view\helper {

        /**
         * Generate Tracking view helper plugin class for tracking visits.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        class generate_mobilede extends base {

            private $protocol = 'http';
            private $product_id = 0;
            private $partner_id = 0;
            private $tracking_id = '';
            private $type = '';

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
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view, $protocol, $product_id, $partner_id, $tracking_id, $type) {

                \shared\classes\calculation\client\common\utils::check_object($view, 'view');
                \shared\classes\calculation\client\common\utils::check_string($protocol, 'protocol', false, array('http', 'https'));
                \shared\classes\calculation\client\common\utils::check_int($product_id, 'product_id');
                \shared\classes\calculation\client\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\calculation\client\common\utils::check_string($tracking_id, 'tracking_id', true);
                \shared\classes\calculation\client\common\utils::check_string($type, 'type', false, array('start', 'lead'));

                $this->protocol = $protocol;
                $this->product_id = $product_id;
                $this->partner_id = $partner_id;
                $this->tracking_id = $tracking_id;
                $this->type = $type;

                parent::__construct($view);

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected function create_output() {

                if ($this->partner_id == 24 && ($this->tracking_id == 'CH24_E_mobile' || $this->tracking_id == 'CH24_T_mobile') && ($this->product_id == 1 || $this->product_id == 2 || $this->product_id == 3)) {

                    if ($this->type == 'start') {

                        $pixel = '<!-- Start of DoubleClick Spotlight Tag: Please do not remove-->' . "\n";
                        $pixel .= '<!-- Activity name for this tag is:1_Startseite -->' . "\n";
                        $pixel .= '<!-- Web site URL where tag should be placed:  -->' . "\n";
                        $pixel .= '<!-- Creation Date:3/1/2011 -->' . "\n";
                        $pixel .= '<img src="' . $this->protocol . '://de.ebayobjects.com/4a;src=2051796;type=preis183;cat=1_sta957;ord=' . rand(0, 999999999) . '?" width="1" height="1" style="border: 0" />' . "\n";
                        $pixel .= '<!-- End of DoubleClick Spotlight Tag: Please do not remove-->' . "\n";

                        return  $pixel;

                    } else {

                        $pixel = '<!-- Start of DoubleClick Spotlight Tag: Please do not remove-->' . "\n";
                        $pixel .= '<!-- Activity name for this tag is:6_Dankeseite -->' . "\n";
                        $pixel .= '<!-- Web site URL where tag should be placed:  -->' . "\n";
                        $pixel .= '<!-- Creation Date:3/1/2011 -->' . "\n";
                        $pixel .= '<img src="' . $this->protocol . '://de.ebayobjects.com/4a;src=2051796;type=preis183;cat=6_dan112;ord=' . rand(0, 999999999) . '?" width="1" height="1" style="border: 0" />' . "\n";
                        $pixel .= '<!-- End of DoubleClick Spotlight Tag: Please do not remove-->' . "\n";

                        return  $pixel;

                    }

                } else {
                    return '';
                }




            }

        }

    }