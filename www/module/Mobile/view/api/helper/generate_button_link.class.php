<?php

    namespace shared\classes\calculation\client\view\helper {

        /**
         * Generate Tracking view helper plugin class for tracking visits.
         *
         * TODO fix class doc
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         */
        class generate_button_link extends base {

            private $partner_id = 0;
            private $tracking_id = '';
            private $image_name = '';
            private $label = '';
            private $url = '';
            private $target = '';
            private $follow = true;

            /**
             * Creates a new tracking generator object.
             *
             * @param \shared\classes\calculation\client\view $view View creating this obj.
             * @param string $partner_id             Partner ID.
             * @param string $tracking_id            Tracking ID.
             * @param string $name                   Name
             * @param string $label                  Label
             * @param boolean $follow                Follow rel
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view, $partner_id, $tracking_id, $image_name, $label, $url, $target = '_self', $follow = NULL) {

                \shared\classes\calculation\client\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\calculation\client\common\utils::check_string($tracking_id, 'tracking_id', true);
                \shared\classes\calculation\client\common\utils::check_string($image_name, 'image_name');
                \shared\classes\calculation\client\common\utils::check_string($label, 'label');
                \shared\classes\calculation\client\common\utils::check_string($url, 'url');
                \shared\classes\calculation\client\common\utils::check_string($target, 'target');

                if ($follow === NULL) {
                    $follow = true;
                }

                \shared\classes\calculation\client\common\utils::check_bool($follow, 'follow');

                $this->partner_id = $partner_id;
                $this->tracking_id = $tracking_id;
                $this->image_name = $image_name;
                $this->label = $label;
                $this->url = $url;
                $this->target = $target;
                $this->follow = $follow;

                parent::__construct($view);

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected function create_output() {
                return '<a class="c24-button" href="' . $this->get_view()->escape($this->url) . '" target="' . $this->get_view()->escape($this->target) . '"' . ($this->follow == false ? ' rel="nofollow"' : '') . '>' . $this->get_view()->escape($this->label) . '</a>';
            }

        }

    }