<?php

    
    namespace classes\filter;

    /**
     * Class represents the default values for child servant.
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class child_servant_state extends abstract_profession_person_state {

        /**
         * Initilize default values for child_servant_state. Some values was defined in parent class.
         *
         * @return void
         */
        public function __construct() {

            parent::__construct();

            $this->settings = array_merge($this->settings, [
                'cure_rehab_visibility'            => true,
                'pdhospital_visibility'            => false,
                'provision_costsharing_visibility' => false,
            ]);

        }

        /**
         * Get the accomodation list
         *
         * @return array
         */
        public function getAccomondationOptions() {
            return [
                'double' => '2-Bett-Zimmer/Chefarzt',
                'single' => '1-Bett-Zimmer/Chefarzt'
            ];
        }

        /**
         * Get the accomodation list for result
         *
         * @return array
         */
        public function getAccomondationOptionsResult() {
            return [
                'double' => '2-Bett-Zimmer/Chefarzt',
                'single' => '1-Bett-Zimmer/Chefarzt'
            ];
        }

    }