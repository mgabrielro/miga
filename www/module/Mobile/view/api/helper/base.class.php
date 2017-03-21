<?php

    namespace shared\classes\calculation\client\view\helper {

        /**
         * Base class of all view helper plug-in classes.
         *
         * @author Philipp Kemmeter <philipp.kemmeter@check24.de>
         */
        abstract class base {

            protected $view = NULL;
            private $output = NULL;

            /**
             * Contructs a new object.
             *
             * @param shared\classes\calculation\client\view $view The parent view.
             * @return void
             */
            public function __construct(\shared\classes\calculation\client\view $view) {
                $this->view = $view;
            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            public function get_output() {

                if ($this->output === NULL) {
                    $this->output = $this->create_output();
                }

                return $this->output;

            }

            /**
             * Returns the rendered output.
             *
             * @return string
             */
            protected abstract function create_output();

            /**
             * Returns the view using this helper.
             *
             * @return \shared\classes\calculation\client\view
             */
            protected function get_view() {
                return $this->view;
            }

        }

    }

?>
