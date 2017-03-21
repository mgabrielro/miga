<?php

    
    namespace classes\filter;

    /**
     * Class represents the default values for adults unemployed.
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class adult_unemployed_state extends abstract_profession_person_state {

        /**
         * Initilize default values for adult_unemployed_state. Some values was defined in parent class.
         *
         * @return void
         */
        public function __construct() {

            parent::__construct();

            $this->settings = array_merge($this->settings, [
                'hospitalization_accommodation'    => 'multi',
                'cure_rehab_visibility'            => false,
                'pdhospital_visibility'            => false,
            ]);

        }

    }