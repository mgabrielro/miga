<?php

    namespace classes\calculation\mclient\controller\helper;
    use \shared\classes\calculation\client\view\helper\base;

    /**
     * Generate tariffdetails
     *
     * @author Florian Saller <florian.saller@check24.de>
     */
    class generate_tariffdetails extends base {

        protected $tariff   = NULL;
        protected $template = NULL;
        //protected $smarty   = NULL;
        private   $tpl_path = NULL;

        /**
         * Constructor
         *
         * @param object $tariff Tariff object
         * @return void
         */
        public function __construct($tariff) {

            \shared\classes\common\utils::check_object($tariff, 'tariff');

            $this->tariff = $tariff;

            if ($this->template === NULL) {
                throw new rs_logic_exception('Please set a template in your subclass');
            }

        }

        /**
         * Implement this in your subclass!
         *
         * @return void
         */
        protected function create_output() {
            throw new rs_logic_exception('Please implement create_output() in your subclass');
        }

    }
