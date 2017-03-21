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
        class generate_button extends base {

            private $partner_id = 0;
            private $tracking_id = '';
            private $image_name = '';
            private $name = '';
            private $label = '';
            private $id = NULL;
            private $type = '';
            private $extra = NULL;

            /**
             * Creates a new tracking generator object.
             *
             * @param \shared\classes\view $view View creating this obj.
             * @param string $partner_id             Partner ID.
             * @param string $tracking_id            Tracking ID.
             * @param string $name                   Name
             * @param string $label                  Label
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view, $partner_id, $tracking_id, $image_name, $name, $label, $id, $type = NULL, $extra = NULL) {

                \shared\classes\calculation\client\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\calculation\client\common\utils::check_string($tracking_id, 'tracking_id', true);
                \shared\classes\calculation\client\common\utils::check_string($image_name, 'image_name');
                \shared\classes\calculation\client\common\utils::check_string($label, 'label');

                if ($id !== NULL) {
                    \shared\classes\calculation\client\common\utils::check_string($id, 'id');
                }

                if ($type !== NULL) {
                    \shared\classes\calculation\client\common\utils::check_string($type, 'type', false, array('submit', 'button'));
                } else {
                    $type = 'submit';
                }

                if ($extra !== NULL) {
                    \shared\classes\calculation\client\common\utils::check_array($extra, 'extra');
                }

                $this->id = $id;
                $this->partner_id = $partner_id;
                $this->tracking_id = $tracking_id;
                $this->label = $label;
                $this->name = $name;
                $this->image_name = $image_name;
                $this->extra = $extra;
                $this->type = $type;

                parent::__construct($view);

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected function create_output() {

                $html_extra = '';

                if ($this->extra !== NULL) {

                    foreach ($this->extra AS $key => $value) {
                        $html_extra .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
                    }

                }

                return '<input type="' . htmlspecialchars($this->type) . '" id="' . ($this->id !== NULL ? $this->id : '') . '" class="c24-button" value="' . $this->get_view()->escape($this->label) . '" name="' . $this->get_view()->escape($this->name) . '"' . $html_extra . '/>';


            }

        }

    }