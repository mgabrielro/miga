<?php

namespace shared\classes\calculation\client\view\helper;
use classes\api\participating_tariff;
use shared\classes\calculation\client\view;

    /**
     * Renders the list of participating tariffs
     *
     * @author Robert Curth <robert.curth@check24.de>
     */
    class tariff_index extends base {

        /**
         * Constructor
         *
         * @param view $view View
         *
         * @return void
         */
        public function __construct(view $view) {
            
            $this->view = $view;

            parent::__construct($view);

        }

        /**
         * Renders the list
         *
         * @return string
         */
        protected function create_output() {
            return $this->view->render('pkv/tariff_index.phtml');
        }

    }