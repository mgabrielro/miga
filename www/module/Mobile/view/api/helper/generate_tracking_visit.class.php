<?php

    namespace shared\classes\calculation\client\view\helper {

        /**
         * Generate Tracking view helper plugin class for tracking visits.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        class generate_tracking_visit extends base {

            private $product_id = 0;
            private $partner_id = 0;
            private $tracking_id = '';
            private $mode_id = '';
            private $deviceoutput = '';
            private $protocol = '';
            private $host = '';

            /**
             * Creates a new tracking generator object.
             *
             * @param \shared\classes\calculation\client\view $view View creating this obj.
             * @param string $host                   Host
             * @param string $protocol               Protocol
             * @param integer $product_id            ID of the product.
             * @param string $partner_id             Partner ID.
             * @param string $tracking_id            Tracking ID.
             * @param string $mode_id                Mode ID.
             * @param string $deviceoutput           Device output
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view, $host, $protocol, $product_id, $partner_id, $tracking_id, $mode_id, $deviceoutput) {

                \shared\classes\calculation\client\common\utils::check_string($host, 'host');
                \shared\classes\calculation\client\common\utils::check_string($protocol, 'protocol');
                \shared\classes\calculation\client\common\utils::check_int($product_id, 'product_id');
                \shared\classes\calculation\client\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\calculation\client\common\utils::check_string($tracking_id, 'tracking_id', true);
                \shared\classes\calculation\client\common\utils::check_string($mode_id, 'mode_id', true);
                \shared\classes\calculation\client\common\utils::check_string($deviceoutput, 'deviceoutput');

                $this->host = $host;
                $this->protocol = $protocol;
                $this->product_id = $product_id;
                $this->partner_id = $partner_id;
                $this->tracking_id = $tracking_id;
                $this->mode_id = $mode_id;
                $this->deviceoutput = $deviceoutput;

                parent::__construct($view);

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected function create_output() {

                // TODO: This has to be changed after url rewrite.

                return '<img src="' . $this->protocol . '://' . $this->host . '/misc/tracking_gif.php' .
                    '?product_id=' . urlencode($this->product_id) .
                    '&partner_id=' . urlencode($this->partner_id) .
                    '&tracking_id=' . urlencode($this->tracking_id) .
                    '&mode_id=' . urlencode($this->mode_id) .
                    '&deviceoutput=' . urlencode($this->deviceoutput) .
                    '&rand=' . urlencode(rand(0, 9999999999)) .
                    '" height="1" width="1" style="border: 0 none;" alt="" />';

            }

        }

    }