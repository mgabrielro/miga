<?php

    
    namespace classes\filter;

    /**
     * Class represents the default values for adults servant and servant candidate.
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class adult_servant_state extends abstract_profession_person_state {

        /**
         * Initilize default values for adult_servant_state. Some values was defined in parent class.
         *
         * @return void
         */
        public function __construct() {

            parent::__construct();

            $this->settings = array_merge($this->settings, [
                'provision_costsharing_limit'      => '1000',
                'hospitalization_accommodation'    => 'double',
                'pdhospital_payout_amount'         => '50',
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